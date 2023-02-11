<?php

namespace App\EventSubscribers;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Quizz;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Repository\QuizzRepository;
use Doctrine\ORM\EntityManagerInterface;



class EditQuizzSubscriber implements EventSubscriberInterface
{


    private $quizzRepository;

    public function __construct( QuizzRepository $quizzRepository,EntityManagerInterface $em)
    {
       
        $this->quizzRepository = $quizzRepository;
        $this->em = $em;
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onPrePut', EventPriorities::PRE_WRITE],
        ];
    }


    #[Route('quizzs/{id}', methods: ['PUT'])]
    public function onPrePut(ViewEvent $event)
    {
    
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Quizz || Request::METHOD_PUT !== $method) {
            return;
        }
        $previousData = $event->getRequest()->attributes->get('previous_data');
      
        if (date_format($previousData->getEndDate(),'Y-m-d')  < date('Y-m-d') ){
            throw new \Exception('Vous ne pouvez pas modifier ce quizz.');
        }

        return;

        
    }
}