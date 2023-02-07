<?php

namespace App\EventSubscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_authentication_success' => 'onAuthenticationSuccess',
        ];
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $user = $event->getUser();

        if (!$user->isEnabled() && $user->getStatus() == 1) {
            $errorMessage = "Veuillez activer votre compte avant de pouvoir vous connecter";
            $event->setData(['error' => $errorMessage]);
            $event->getResponse()->setStatusCode(403);
        }
    }
}