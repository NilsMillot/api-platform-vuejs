<?php
namespace App\Controller;


use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Charge;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use App\Repository\MovieScreeningRepository;

#[AsController]
class BookingController extends AbstractController
{

    private $price;
    private $session;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, HttpClientInterface $httpClient,UserRepository $userRepository, BookingRepository $bookingRepository, MovieScreeningRepository $movieScreeningRepository, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;
        $this->requestStack = $requestStack;
        $this->bookingRepository = $bookingRepository;
        $this->userRepository = $userRepository;
        $this->movieScreeningRepository = $movieScreeningRepository;
        $this->price = 0;
        $this->session = [];
        

    }
    
    public function __invoke(Request $request, MailerInterface $mailer):JsonResponse
    {
        try {
            $parameters = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

            $user = $this->getUser();

            if (empty($parameters['price']) && empty($parameters['items']) && empty($parameters['session'])){
                return $this->json(['message' => 'Une erreur est survenue'], 400);
            }

            $getSession = $this->movieScreeningRepository->findById($parameters['session']['id']);
            $verifyDate = date_format($getSession[0]->getSessionDatetime(),"d-m-Y h:i:s") < date('d-m-Y h:i:s');

            if ($verifyDate == true || $getSession[0]->getStatus() == -1 ){
                return $this->json(['message' => "Erreur au niveau de la séance"], 400);
            }

            foreach($parameters['items'] as $item){
                $booking = $this->bookingRepository->findById($item['id']);
                if ($booking[0]->getBuyerId() != null){
                    return $this->json(['message' => "La place " . $booking[0]->getSeat() ." a déjà été réservé"], 400);
                }
                if ($booking[0]->getSessionId()->getId() != $getSession[0]->getId()){
                    return $this->json(['message' => "Erreur"], 400);
                }
            }


            $countSeat = count($parameters['items']);
            $this->price = $getSession[0]->getPrice() * $countSeat;

            if ($this->price != $parameters['price']){
                return $this->json(['message' => "Erreur au niveau du prix de la séance"], 400);
            }

            $this->session = $getSession[0];

            if (empty($parameters['cardNumber'])
                || empty($parameters['cardMonth'])
                || empty($parameters['cardYear'])
                || empty($parameters['cardCvv'])) {
                return $this->json(['message' => 'Les données de la carte sont manquantes'], 400);
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

            

            Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

            $token = Token::create([
                'card' => [
                    'number' => $cardNumber,
                    'exp_month' => $cardMonth,
                    'exp_year' => $cardYear,
                    'cvc' => $cardCvv,
                ],
            ]);

            $charge = Charge::create([
                'amount' => $parameters['price'] * 100,
                'currency' => 'eur',
                'source' => $token,
            ]);


            foreach($parameters['items'] as $item){
                $booking = $this->bookingRepository->findById($item['id']);
                $booking[0]->setBuyerId($user);
                $this->em->flush();
            }



            $emailHtml = $this->generateOrderRecapHtml($parameters);

            $email = (new Email())
                ->from('cinemax.esgi@gmail.com')
                ->to($user->getEmail())
                ->subject('Récapitulatif de votre commande')
                ->html($emailHtml);

            $mailer->send($email);



            return $this->json(['message' => "success"], 200);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Une erreur est survenue'], 500);
        }

    }


    private function generateOrderRecapHtml($parameters): string
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
                            border-bottom: 1px solid #000000;
                            padding-bottom: 20px;
                        }

                        .movie-name {
                            margin-bottom: 20px;
                            border-bottom: 1px solid #000000;
                            padding-bottom: 20px;
                            color: #000000;
                        }

                        .movie-title {
                            color: #000000;
                            font-weight: bold;
                        }

                        .total {
                            margin-top: 20px;
                            font-weight: bold;
                            color: #000000;
                            text-align: right;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">Votre confirmation de commande - CINEMAX </div>
                        <div class="content">
                            <div class="movies">';

                    $priceToDisplay = number_format($this->price, 2, ',', ' ');
                    $quantity = count($parameters['items']);

                    $html .= '
                        <div class="movie-name">
                            <div class="">' . $this->session->getMovieTitle() . '</div>
                            <div class="">' . date_format($this->session->getSessionDatetime(),"d/m/Y à h:i") . '</div>
                            <div class="">' . $this->session->getCreator()->getName() . '</div>
                            <div class="">' . $quantity .' place(s)</div>
                        </div>';

                    foreach( $parameters['items'] as $item){
                        $html .= '
                        <div class="movie">
                            <div class="movie-title">Siège ' . $item['seat'] . " à " . number_format($this->session->getPrice(), 2, ',', ' ') . " €" .'</div>
                        </div>';
                    }

                    $html .= '
                            </div>
                            <div class="total">Total: ' . $priceToDisplay . ' €</div>
                        </div>
                    </div>
                </body>
            </html>';

            return $html;
    }
}
