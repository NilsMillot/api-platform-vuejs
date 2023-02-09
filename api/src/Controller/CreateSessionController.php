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
class CreateSessionController extends AbstractController
{


    
    public function __invoke(Request $request, ValidatorInterface $validator, EntityManagerInterface $em, SerializerInterface $serializer, MovieScreening $movieScreening, MovieScreeningRepository $movieScreeningRepository, UserRepository $userRepository, BookingRepository $bookingRepository, RequestStack $requestStack): JsonResponse
    {
        try {
            $parameters = json_decode($requestStack->getCurrentRequest()->getContent(), true);
            $user = $this->getUser();

            if (
                empty($parameters['sessionDatetime'])
                || empty($parameters['price'])
                || empty($parameters['movieId'])
                || empty($parameters['movieTitle'])
            ) {
                return $this->json(['message' => 'Veuillez remplir tous les champs'], 400);
            }

            if (in_array("ROLE_ADMIN", $user->getRoles())) {

                if (empty($parameters['cinema'])) {
                    return $this->json(['message' => 'Veuillez remplir tous les champs'], 400);
                }
                $user = $userRepository->findById($parameters['cinema']);
                $user = $user[0];
            }

            if (!in_array("ROLE_CINEMA", $user->getRoles())) {
                return $this->json(['message' => 'Une erreur est survenue.'], 400);
            }

            $errors = $validator->validate($movieScreening);
            if (count($errors) > 0) {
                return $this->json(['message' => "Erreur au niveau du formulaire"], 400);
            }

            $sessionDatetime = new DateTime($parameters['sessionDatetime']);

            $session = new MovieScreening();
            $session->setSessionDatetime($sessionDatetime);
            $session->setPrice($parameters['price']);
            $session->setMovieId($parameters['movieId']);
            $session->setMovieTitle($parameters['movieTitle']);
            $session->setRoom(1);
            $session->setStatus(1);
            $session->setCreator($user);

            $em->persist($session);

            for ($i = 1; $i <= 30; $i++) {
                $seat = new Booking();
                $seat->setSeat($i);
                $seat->setSessionId($session);
                $seat->setStatus(1);
                $seat->setBuyerId(NULL);
                $em->persist($seat);
            }

            $em->flush();

            return $this->json(['message' => "Séance créée."], 201);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Une erreur est survenue'], 500);
        }
    }
}
