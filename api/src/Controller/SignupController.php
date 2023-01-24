<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\SignupDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;


#[AsController]
class SignupController extends AbstractController
{
    public function __invoke(ValidatorInterface $validator, SignupDto $signupDto, MailerInterface $mailer, SerializerInterface $serializer, EntityManagerInterface $em, UserRepository $userRepository): JsonResponse
    {
        $validator->validate($signupDto);

        $user = new User();
        $user->setEmail($signupDto->email);
        $user->setPassword($signupDto->password);
        $user->setConfirmationToken(bin2hex(random_bytes(32)));
        $em->persist($user);
        $em->flush();

        $user = $userRepository->findOneBy(['email' => $signupDto->email]);

        $enableAccountLink = $_ENV['CLIENT_BASE_URL'] . '/enable_account' .  '?token=' . $user->getConfirmationToken();
        $emailBody = $this->createEmailBody($enableAccountLink);

        $email = (new Email())
            ->from('cinemax.esgi@gmail.com')
            ->to($user->getEmail())
            ->subject('Confirmation de votre compte Cinemax')
            ->html($emailBody);

        $mailer->send($email);

        return $this->json(['success' => 'Account created but not enabled, activate the account by clicking the link sent by email'], 201);
    }

    private function createEmailBody($enableAccountLink): string {
        return "
            <!DOCTYPE html>
            <html>
              <head>
                <style>
                  .container {
                    max-width: 600px;
                    margin: 0 auto;
                    text-align: center;
                  }
                
                  h1 {
                    font-size: 36px;
                    font-weight: bold;
                    color: #e50914;
                    margin-top: 50px;
                    margin-bottom: 30px;
                  }
                
                  p {
                    font-size: 18px;
                    line-height: 1.5;
                    margin-bottom: 20px;
                  }
                
                  a {
                    display: inline-block;
                    padding: 12px 24px;
                    font-size: 18px;
                    font-weight: bold;
                    text-decoration: none;
                    text-transform: uppercase;
                    background-color: #e50914;
                    color: #fff !important;
                    border-radius: 4px;
                    margin-top: 20px;
                  }
                
                  a:hover {
                    background-color: #333;
                    color: #fff;
                  }
                </style>
              </head>
              <body>
                <div class='container'>
                  <h1>Bienvenue chez Cinemax !</h1>
                  <p>Bienvenue chez Cinemax. Pour activer votre compte, cliquez sur le bouton ci-dessous.</p>
                  <a href='" . $enableAccountLink . ">Activez votre compte</a>
                </div>
              </body>
            </html>
        ";
    }
}
