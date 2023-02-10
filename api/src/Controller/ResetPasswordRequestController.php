<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\ResetPasswordRequestDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsController]
class ResetPasswordRequestController extends AbstractController
{
    public function __invoke(ResetPasswordRequestDto $resetPasswordRequestDto, EntityManagerInterface $em, UserRepository $userRepository, MailerInterface $mailer, ValidatorInterface $validator): JsonResponse
    {
        $validator->validate($resetPasswordRequestDto);
        $user = $userRepository->findOneBy(['email' => $resetPasswordRequestDto->getEmail()]);

        if ($user) {
            $user->setResetPasswordToken(bin2hex(random_bytes(32)));
            $em->flush();

            $resetPasswordLink = $_ENV['CLIENT_BASE_URL'] . '/new-password?reset_password_token=' . $user->getResetPasswordToken();
            $emailBody = "
                <html>
                  <head>
                    <style>
                      body {
                        font-family: Arial, sans-serif;
                        background-color: #f9f9f9;
                        padding: 50px;
                      }
                
                      h1 {
                        color: #e50914;
                        text-align: center;
                        margin-bottom: 40px;
                      }
                
                      .btn {
                        background-color: #e50914;
                        color: #fff !important;
                        padding: 10px 20px;
                        border-radius: 20px;
                        text-decoration: none;
                        display: inline-block;
                        margin-top: 30px;
                        margin-bottom: 30px;
                      }
                    </style>
                  </head>
                  <body>
                    <h1>Réinitialisation de votre mot de passe</h1>
                    <p>Bonjour,</p>
                    <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte Cinemax. Si vous n'avez pas fait cette demande, vous pouvez ignorer ce mail.</p>
                    <p>Pour réinitialiser votre mot de passe, cliquez sur le bouton ci-dessous :</p>
                    <a href='{$resetPasswordLink}' class='btn'>Réinitialiser le mot de passe</a>
                    <p>Merci,</p>
                    <p>L'équipe Cinemax</p>
                  </body>
                </html>";

            $email = (new Email())
                ->from('cinemax.esgi@gmail.com')
                ->to($user->getEmail())
                ->subject('Demande de réinitialisation de mot de passe')
                ->html($emailBody);

            $mailer->send($email);

            $response = new JsonResponse();
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode(['success' => 'Email sent']));
            $response->setStatusCode(200);

            return $response;
        }

        return $this->json(['error' => 'Email invalide'], 404);
    }
}