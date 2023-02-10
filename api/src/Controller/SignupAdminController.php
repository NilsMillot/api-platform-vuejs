<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\SignupAdminDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;


#[AsController]
class SignupAdminController extends AbstractController
{
    public function __invoke(ValidatorInterface $validator, SignupAdminDto $signupDto, MailerInterface $mailer, SerializerInterface $serializer, EntityManagerInterface $em, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $validator->validate($signupDto);

        $user = new User();
        $user->setEmail($signupDto->email);
        // Generate an random password with 8 characters
        $randomPassword = bin2hex(random_bytes(4));

        $user->setPassword($passwordHasher->hashPassword($user, $randomPassword));
        $user->setEnabled(true);

        if ($signupDto->isCinema){
          $user->setRoles(['ROLE_CINEMA']);
        } else if ($signupDto->isAdmin){
          $user->setRoles(['ROLE_ADMIN']);
        } else {
          $user->setRoles(['ROLE_USER']);
        }
        
        $user->setName($signupDto->name);
        $user->setAdress($signupDto->adress);
        $em->persist($user);
        $em->flush();

        $user = $userRepository->findOneBy(['email' => $signupDto->email]);

        $clientBaseUrl = $_ENV['CLIENT_BASE_URL'];
        $emailBody = $this->createEmailBody($signupDto->email, $randomPassword, $clientBaseUrl);

        $email = (new Email())
            ->from('cinemax.esgi@gmail.com')
            ->to($user->getEmail())
            ->subject('Création de votre compte Cinemax')
            ->html($emailBody);

        $mailer->send($email);

        return $this->json(['success' => 'Account created and enabled, user has to check his email to get his login details'], 201);
    }

    private function createEmailBody($mail, $pwd, $clientBaseUrl): string {
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
                  <p>Bienvenue chez Cinemax. Votre compte est activé.</p>
                  <p>mail: '{$mail}'</p>
                  <p>mot de passe: '{$pwd}'</p>
                  <a href='{$clientBaseUrl}/login'>Connectez vous ici</a>
                </div>
              </body>
            </html>
        ";
    }
}
