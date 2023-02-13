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



class PublishQuizzSubscriber implements EventSubscriberInterface
{


    private $quizzRepository;
    private $questionRepository;

    public function __construct(QuizzRepository $quizzRepository, QuestionRepository $questionRepository, EntityManagerInterface $em)
    {

        $this->quizzRepository = $quizzRepository;
        $this->questionRepository = $questionRepository;
        $this->em = $em;
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onPrePut', EventPriorities::PRE_WRITE],
        ];
    }


    #[Route('quizz/publish/{id}', methods: ['PUT'])]
    public function onPrePut(ViewEvent $event)
    {

        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Quizz || Request::METHOD_PUT !== $method) {
            return;
        }
        
        $getQuestion = $this->questionRepository->findBy(['quizz' => $entity->getId()]);

        if (count($getQuestion) < 1) {
            throw new \Exception('Vous ne pouvez pas publier ce quizz.');
        }

        return;
    }
}
