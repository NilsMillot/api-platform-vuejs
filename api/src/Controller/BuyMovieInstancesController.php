<?php

namespace App\Controller;

use App\Repository\MovieInstanceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsController]
class BuyMovieInstancesController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, HttpClientInterface $httpClient, MovieInstanceRepository $movieInstanceRepository, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;
        $this->requestStack = $requestStack;
        $this->movieInstanceRepository = $movieInstanceRepository;
    }
    public function __invoke(Request $request, MailerInterface $mailer):JsonResponse
    {
        try {
            $parameters = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

            if (empty($parameters['cardNumber'])
                || empty($parameters['cardMonth'])
                || empty($parameters['cardYear'])
                || empty($parameters['cardCvv'])) {
                return $this->json(['message' => 'Les données de la carte sont manquantes'], 400);
            }

            if (empty($parameters['price']) ||
                empty($parameters['items']) ||
                count($parameters['items']) == 0 ||
                $parameters['price'] <= 0){
                return $this->json(['message' => 'Une erreur est survenue'], 400);
            }

            $cardNumber = trim($parameters['cardNumber']);
            $cardMonth = trim($parameters['cardMonth']);
            $cardYear = trim($parameters['cardYear']);
            $cardCvv = trim($parameters['cardCvv']);

            if (!preg_match('/^[0-9]{16}$/', $cardNumber)) {
                return $this->json(['message' => 'Le numéro de carte est invalide'], 400);
            }

            $current_date = new DateTime();
            $card_expire = new DateTime($cardYear . "-" . $cardMonth . "-01");

            if ($card_expire < $current_date) {
                return $this->json(['message' => 'La date d\'expiration de la carte est dépassée'], 400);
            }


            if (!preg_match('/^[0-9]{3}$/', $cardCvv)) {
                return $this->json(['message' => 'Le code de sécurité de la carte est invalide'], 400);
            }

            $firstMovieInstance = $this->movieInstanceRepository->find($parameters['items'][0]['id']);
            $movie = $firstMovieInstance->getMovie();

            if ($movie->getPrice() * count($parameters['items']) != $parameters['price']) {
                return $this->json(['message' => 'Le prix ne correspond pas'], 400);
            }

            Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

            $token = Token::create([
                'card' => [
                    'number' => $cardNumber,
                    'exp_month' => $cardMonth,
                    'exp_year' => $cardYear,
                    'cvc' => $cardCvv,
                ],
            ]);

            $price = $parameters['price'];
            $oldTotalCredits = $this->getUser()->getTotalCredits();

            if ($oldTotalCredits >= $price - 1) {
                $this->getUser()->setTotalCredits($oldTotalCredits - $price + 1);
                $price = 1;
            } else {
                $price = $price - $oldTotalCredits;
                $this->getUser()->setTotalCredits(0);
            }

            $charge = Charge::create([
                'amount' => $price * 100,
                'currency' => 'eur',
                'source' => $token,
            ]);

            foreach($parameters['items'] as $item){
                $movie_instance = $this->movieInstanceRepository->find($item['id']);
                $movie_instance->setBuyer($this->getUser());
                $movie_instance->setBuyedDate(new DateTime());
            }

            $emailHtml = $this->generateOrderRecapHtml($parameters, $price, $oldTotalCredits);

            $email = (new Email())
                ->from('cinemax.esgi@gmail.com')
                ->to($this->getUser()->getEmail())
                ->subject('Récapitulatif de votre commande')
                ->html($emailHtml);

            $mailer->send($email);

            $this->em->flush();

            return $this->json(['message' => "success"], 200);
        } catch (\Exception $e) {
            return $this->json(['message' => $e], 500);
        }

    }

    private function generateOrderRecapHtml($parameters, $price_with_credits, $old_total_credits): string
    {

        $html = '
<!DOCTYPE html>
<html>
    <head>
        <style>
            .container {
                width: 80%;
                margin: 0 auto;
                font-family: Arial, sans-serif;
            }

            .header {
                background-color: #e50914;
                color: #ffffff;
                padding: 20px;
                text-align: center;
                font-size: 36px;
                font-weight: bold;
            }

            .content {
                background-color: #ffffff;
                padding: 20px;
                font-size: 18px;
            }

            .movies {
                margin-top: 20px;
            }

            .movie {
                margin-bottom: 20px;
                border-bottom: 1px solid #e50914;
                padding-bottom: 20px;
            }

            .movie-title {
                color: #e50914;
                font-weight: bold;
            }

            .total {
                margin-top: 20px;
                font-weight: bold;
                color: #e50914;
                text-align: right;
            }
            
            .credits {
                font-weight: bold;
                margin-top: 20px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">Votre commande Cinemax</div>
            <div class="content">
                <div class="movies">';

        $price = $parameters['price'] / count($parameters['items']);
        $priceToDisplay = number_format($price, 2, ',', ' ');
        $quantity = count($parameters['items']);

        $movie_instance = $this->movieInstanceRepository->find($parameters['items'][0]['id']);
        $movie = $movie_instance->getMovie();
        $movie_title = $movie->getTitle();

        $html .= '
                <div class="movie">
                    <div class="movie-title">' . $movie_title . ' x' . $quantity . '</div>
                    <div>' . $priceToDisplay . ' €</div>
                </div>';

        $total_price = $parameters['price'];
        $total_price_to_display = number_format($total_price, 2, ',', ' ');

        $price_with_credits_to_display = number_format($price_with_credits, 2, ',', ' ');
        $old_total_credits_to_display = number_format($old_total_credits, 0, ',', ' ');
        $new_total_credits_to_display = number_format($this->getUser()->getTotalCredits(), 0, ',', ' ');
        $used_credits = $old_total_credits - $this->getUser()->getTotalCredits();
        $used_credits_to_display = number_format($used_credits, 0, ',', ' ');


        $html .= '
                </div>
                <p>Rappel : 1 crédit = 1 euro de réduction sur votre commande</p>
                <div class="credits">Vos crédits avant l\'achat: ' . $old_total_credits_to_display . '</div>
                <div class="credits">Crédits utilisés: ' . $used_credits_to_display . '</div>
                <div class="credits">Vos crédits après l\'achat: ' . $new_total_credits_to_display . '</div>
                <div class="total">Prix Total: ' . $total_price_to_display . ' €</div>
                <div class="total">Prix Total (avec les crédits): ' . $price_with_credits_to_display . ' €</div>
            </div>
        </div>
    </body>
</html>';

            return $html;
    }
}