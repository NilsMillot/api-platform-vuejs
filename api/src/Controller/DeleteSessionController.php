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
class DeleteSessionController extends AbstractController
{

    public function __invoke(Request $request, String $id, ValidatorInterface $validator, EntityManagerInterface $em, SerializerInterface $serializer, MovieScreening $movieScreening, MovieScreeningRepository $movieScreeningRepository, UserRepository $userRepository, BookingRepository $bookingRepository, RequestStack $requestStack): JsonResponse
    {

        try {

            $user = $this->getUser();
            $session = $movieScreeningRepository->findById($id);

            if (in_array("ROLE_CINEMA", $user->getRoles())){

                $session = $movieScreeningRepository->findBy([
                    "id" => $id,
                    "creator" => $user->getId()
                ]);

                if (count($session) < 1){
                    return $this->json(['message' => "Une erreur est survenue."], 400);
                } 
            }

            $bookings = $bookingRepository->findBy(
                [
                    'buyer_id' => NULL,
                    'session_id' => $session[0]->getId()
                ]
            );

            if (count($bookings) < 30) {
                return $this->json(['message' => "Vous ne pouvez pas supprimer cette séance."], 400);
            }

            $session[0]->setStatus(-1);
            $em->flush();

            return $this->json(['message' => "Séance supprimée."], 200);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Une erreur est survenue'], 500);
        }
    }
}
