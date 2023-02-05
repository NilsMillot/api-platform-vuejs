<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;


#[AsController]
class CurrentUserController extends AbstractController
{
    public function __invoke(UserRepository $userRepository, Request $request, SerializerInterface $serializer): JsonResponse
    {
      $user = $this->getUser();

      if ($user instanceof User) {
          return $this->json($user, 200, [], ['groups' => ['user:read']]);
      }

      return $this->json(null, 404);
      
    }
}
