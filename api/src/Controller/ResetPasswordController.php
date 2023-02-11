<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\ResetPasswordDto;
use App\Dto\ResetPasswordRequestDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class ResetPasswordController extends AbstractController
{
    public function __invoke(ValidatorInterface $validator, ResetPasswordDto $resetPasswordDto, UserRepository $userRepository, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $validator->validate($resetPasswordDto);

        $user = $userRepository->findOneBy(['resetPasswordToken' => $resetPasswordDto->getResetPasswordToken()]);

        if (!$user) {
            return $this->json(['error' => "L'utilisateur n'a pas été trouvé"], 404);
        }

        $hashedPassword = $passwordHasher->hashPassword($user, $resetPasswordDto->getPassword());
        $user->setPassword($hashedPassword);
        $user->setResetPasswordToken(null);
        $em->persist($user);
        $em->flush();

        return $this->json(['success' => 'Votre mot de passe a été mis à jour'], 200);
    }
}