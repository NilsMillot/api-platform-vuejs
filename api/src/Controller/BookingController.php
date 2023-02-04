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
use App\Entity\Movie;

#[AsController]
class BookingController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, HttpClientInterface $httpClient)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->httpClient = $httpClient;
    }

    public function __invoke(Request $request):JsonResponse
    {
        // $dto = $this->serializer->deserialize($request->getContent(), CreateMovieInstancesDto::class, 'json');

        \Stripe\Stripe::setApiKey("sk_test_51LGVfsBYnbPwVzITdZ1beyU8wGKOFIZDYQNHbysLI7wof5e2n3SPGhdkPVsOvkzsfFWnb8btlVhoCuG5X3Kk1OqA004NNlVIXq");
        
        $YOUR_DOMAIN = "https://localhost/";
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => 100,
                    'product_data' => [
                        'name' => 'Test',
                        'images' => [],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . 'success',
            'cancel_url' => $YOUR_DOMAIN . 'cancel',
        ]);
    
        return $this->json(['message' => $checkout_session->url], 200);
      
        return $this->json(['message' => "ok"], 200);
    
    }

}
