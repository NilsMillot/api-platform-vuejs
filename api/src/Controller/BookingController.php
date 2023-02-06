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
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;

#[AsController]
class BookingController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, HttpClientInterface $httpClient,UserRepository $userRepository, BookingRepository $bookingRepository, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;
        $this->requestStack = $requestStack;
        $this->bookingRepository = $bookingRepository;
        $this->userRepository = $userRepository;

    }
    
    public function __invoke(Request $request):JsonResponse
    {
        try {
            $parameters = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

            if (empty($parameters['cardNumber'])
                || empty($parameters['cardMonth'])
                || empty($parameters['cardYear'])
                || empty($parameters['cardCvv'])) {
                return $this->json(['message' => 'Les données de la carte sont manquantes'], 400);
            }

            if (empty($parameters['price']) && empty($parameters['items'])){
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
                $user = $this->userRepository->findById(1);
                $booking[0]->setBuyerId($user[0]);
                $this->em->flush();
            }

            return $this->json(['message' => "success"], 200);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Une erreur est survenue'], 500);
        }

    }
}
