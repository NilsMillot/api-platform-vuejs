<?php

namespace App\Controller;

use App\Dto\EnableAccountDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class EnableAccountController extends AbstractController
{
    public function __invoke(EnableAccountDto $enableAccountDto, User $user, EntityManagerInterface $em): JsonResponse
    {

        if ($user->getConfirmationToken() === $enableAccountDto->getToken()) {
            $user->setConfirmationToken('');
            $user->setEnabled(true);
            $em->flush();

            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode(['success' => 'Account enabled']));
            $response->setStatusCode(200);

            return $response;
        }
        return $this->json(['error' => 'User not found, invalid Token, or account already enabled'], 400);
    }
}