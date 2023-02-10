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
class UpdateSessionController extends AbstractController
{
    public function __invoke(Request $request,ValidatorInterface $validator, String $id, EntityManagerInterface $em, SerializerInterface $serializer,MovieScreening $movieScreening, MovieScreeningRepository $movieScreeningRepository, UserRepository $userRepository,BookingRepository $bookingRepository, RequestStack $requestStack):JsonResponse
    {

        try{
            $parameters = json_decode($requestStack->getCurrentRequest()->getContent(), true);
            $user = $this->getUser();

            if (in_array("ROLE_CINEMA", $user->getRoles())){
                $session = $movieScreeningRepository->findBy([
                    "id" => $id,
                    "creator" => $user->getId()
                ]);

                if (count($session) < 1){
                    return $this->json(['message' => "Une erreur est survenue."], 400);
                } 
            }else{
                $session = $movieScreeningRepository->findById($id);
            }

            if($session[0]->getStatus() == -1){
                return $this->json(['message' => 'Vous ne pouvez plus modifier cette séance'], 400);
            }
        
            if (empty($parameters['sessionDatetime'])){
                return $this->json(['message' => 'Veuillez remplir tous les champs'], 400);
            }

            $errors = $validator->validate($movieScreening);
            if (count($errors) > 0) {
                return $this->json(['message' => "Erreur au niveau du formulaire"], 400);
            }

            $sessionDatetime = new DateTime($parameters['sessionDatetime']);

            $session[0]->setSessionDatetime($sessionDatetime);
            $em->flush();

            return $this->json(['message' => "Séance modifiée."], 201);
        }catch (\Exception $e) {
            return $this->json(['message' => 'Une erreur est survenue'], 500);
        }
    }
}
