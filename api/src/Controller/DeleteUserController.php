<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class DeleteUserController extends AbstractController
{
    public function __invoke(ValidatorInterface $validator, User $user, EntityManagerInterface $em, UserRepository $userRepository): JsonResponse
    {   
        $user->setStatus('deleted');
        $em->persist($user);
        $em->flush();

        return $this->json(['success' => 'Account deleted'], 204);
    }
}
