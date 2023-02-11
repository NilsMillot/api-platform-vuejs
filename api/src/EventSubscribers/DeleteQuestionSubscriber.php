<?php

namespace App\EventSubscribers;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Quizz;
use App\Entity\Question;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Repository\QuizzRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;



class DeleteQuestionSubscriber implements EventSubscriberInterface
{

    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository, EntityManagerInterface $em)
    {

        $this->questionRepository = $questionRepository;
        $this->em = $em;
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onPreDelete', EventPriorities::PRE_WRITE],
        ];
    }

    public function onPreDelete(ViewEvent $event)
    {

        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Question || Request::METHOD_DELETE !== $method) {
            return;
        }
        $previousData = $event->getRequest()->attributes->get('previous_data');

        if (
            $previousData->getQuizz()->getId() != $entity->getQuizz()->getId() ||
            $previousData->getId() != $entity->getId()
        ) {
            throw new \Exception("Une erreur est survenue");
        }

        if ($entity->getQuizz()->getStatus() == 1) {
            throw new \Exception("Vous ne pouvez pas supprimer la question.");
        }

        return;
    }
}