<?php

namespace App\Controller;

use App\Dto\UpdateUserDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class UpdateUserController extends AbstractController
{
  public function __invoke(UpdateUserDto $updateUserDto, EntityManagerInterface $em): JsonResponse
  {
    if($this->getUser()) {
      if ($updateUserDto->getName()) $this->getUser()->setName($updateUserDto->getName());
      if ($updateUserDto->getAdress()) $this->getUser()->setAdress($updateUserDto->getAdress());
      if ($updateUserDto->getStatus()) $this->getUser()->setStatus($updateUserDto->getStatus());

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
