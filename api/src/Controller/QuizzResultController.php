<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\QuizzResultDto;
use App\Entity\QuizzResult;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use App\Repository\QuizzResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class QuizzResultController extends AbstractController
{
    public function __invoke(ValidatorInterface $validator, QuizzRepository $quizzRepository, QuizzResultDto $quizzResultDto, QuizzResultRepository $quizzResultRepository, QuestionRepository $questionRepository, EntityManagerInterface $em): JsonResponse
    {
        $validator->validate($quizzResultDto);
        foreach ($quizzResultDto->getAnswers() as $answer) {
            $validator->validate($answer);
        }

        $userId = $this->getUser()->getId();
        $quizzId = $quizzResultDto->getQuizzId();

        $quizz = $quizzRepository->find($quizzId);
        if (!$quizz) {
            return $this->json(['message' => 'Ce quizz n\'existe pas'], 400);
        }

        if ($quizz->getStatus() !== 1) {
            return $this->json(['message' => 'Ce quizz n\'est pas encore publié'], 400);
        }

        $oldUserResult = $quizzResultRepository->findOneBy(['participant' => $userId, 'quizz' => $quizzId]);
        if ($oldUserResult) {
            return $this->json(['message' => 'Vous avez déjà répondu à ce quizz'], 400);
        }

        if (count($quizzResultDto->getAnswers()) < $questionRepository->count(['quizz' => $quizzId])) {
            return $this->json(['message' => 'Vous n\'avez pas répondu à toutes les questions'], 400);
        }

        if (count($quizzResultDto->getAnswers()) > $questionRepository->count(['quizz' => $quizzId])) {
            return $this->json(['message' => 'Vous avez envoyé trop de réponses'], 400);
        }

        $questionIds = [];
        foreach ($quizzResultDto->getAnswers() as $answer) {
            if (in_array($answer->getQuestionId(), $questionIds)) {
                return $this->json(['message' => 'Vous avez répondu plusieurs fois à la même question'], 400);
            }
            $questionIds[] = $answer->getQuestionId();
        }

        foreach ($quizzResultDto->getAnswers() as $answer) {
            $question = $questionRepository->find($answer->getQuestionId());
            if (!$question || $question->getQuizz()->getId() !== $quizzId) {
                return $this->json(['message' => 'Une des questions auxquel vous avez répondu n\'existe pas dans ce quizz'], 400);
            }
        }

        $maxScore = $questionRepository->count(['quizz' => $quizzId]);
        $userScore = 0;
        foreach ($quizzResultDto->getAnswers() as $answer) {
            $question = $questionRepository->find($answer->getQuestionId());
            if ($question->getCorrectAnswer() === $answer->getAnswer()) {
                $userScore++;
            }
        }

        $successMessage = "";
        if ($userScore === $maxScore) {
            $this->getUser()->setTotalCredits($this->getUser()->getTotalCredits() + 20);
            $successMessage = "Votre score : $userScore / $maxScore. Bravo, vous avez remporté 20 crédits !";
        } else {
            $successMessage = "Votre score : $userScore / $maxScore, merci d'avoir participé !";
        }

        $quizzResult = new QuizzResult();
        $quizzResult->setParticipant($this->getUser());
        $quizzResult->setQuizz($quizz->getQuizz());
        $quizzResult->setScore($userScore);
        $em->persist($quizzResult);

        $em->flush();

        return $this->json(['message' => $successMessage], 201);
    }
}