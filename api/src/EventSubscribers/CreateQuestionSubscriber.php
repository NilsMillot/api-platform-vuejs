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



class CreateQuestionSubscriber implements EventSubscriberInterface
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
            KernelEvents::VIEW => ['onPrePost', EventPriorities::PRE_WRITE],
        ];
    }

    public function onPrePost(ViewEvent $event)
    {

        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Question || Request::METHOD_POST !== $method) {
            return;
        }

        if ($entity->getQuizz()->getStatus() == 1) {
            throw new \Exception("Vous ne pouvez plus créer de question. Le quizz est publié.");
        }

        return;
    }
}