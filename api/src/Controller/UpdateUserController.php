<?php

namespace App\Controller;

use App\Dto\UpdateUserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class UpdateUserController extends AbstractController
{
  public function __invoke(UpdateUserDto $updateUserDto, User $user, EntityManagerInterface $em): JsonResponse
  {
    if($user && $this->getUser() && ($this->getUser()->getRoles() === ['ROLE_ADMIN'] || $this->getUser()->getId() === $user->getId())) {
      if ($updateUserDto->getName()) $user->setName($updateUserDto->getName());
      if ($updateUserDto->getAdress()) $user->setAdress($updateUserDto->getAdress());
      
      if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
        if ($updateUserDto->getRoles()) $user->setRoles($updateUserDto->getRoles());
        if ($updateUserDto->getTotalCredits()) $user->setTotalCredits($updateUserDto->getTotalCredits());
      }

      $em->flush();

      $response = new JsonResponse();
      $response->headers->set('Content-Type', 'application/json');
      $response->setContent(json_encode(['success' => 'User updated']));
      $response->setStatusCode(200);

      return $response;
    }

    return $this->json(['error' => 'User not found, invalid Token, or account already enabled'], 400);
  }
}
