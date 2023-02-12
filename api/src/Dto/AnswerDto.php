<?php

namespace App\Dto;

// import constraints
use Symfony\Component\Validator\Constraints as Assert;

class AnswerDto
{
    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    private int $questionId;

    #[Assert\NotNull]
    #[Assert\Choice(choices: [1, 2], message: 'Answer must be 1 or 2')]
    private int $answer;

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): self
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getAnswer(): int
    {
        return $this->answer;
    }

    public function setAnswer(int $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}