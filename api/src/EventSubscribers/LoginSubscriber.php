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

        if (!$user->isEnabled()) {
            $errorMessage = "Il semble que vous n'ayez pas encore activé votre compte ou bien que votre compte ait été bloqué. Veuillez consulter votre boîte mail.";
            $event->setData(['error' => $errorMessage]);
            $event->getResponse()->setStatusCode(403);
        }
    }
}