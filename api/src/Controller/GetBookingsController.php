<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Entity\MovieScreening;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use DateTime;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use App\Repository\MovieScreeningRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class GetBookingsController extends AbstractController
{

    public function __invoke(Request $request, String $id, ValidatorInterface $validator, EntityManagerInterface $em, SerializerInterface $serializer, MovieScreening $movieScreening, MovieScreeningRepository $movieScreeningRepository, UserRepository $userRepository, BookingRepository $bookingRepository, RequestStack $requestStack): JsonResponse
    {

        try {

            $user = $this->getUser();

            $session = $movieScreeningRepository->findById($id);

            if (count($session) < 1){
                return $this->json(['message' => "Une erreur est survenue."], 400);
            } 

            $seats = $bookingRepository->findBy([
                "session_id" => $session[0]->getId(),
            ]);

            return $this->json(['data' => $seats], 200);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Une erreur est survenue'], 500);
        }
    }
}
