<?php

namespace App\Dto;

// import constraints
use Symfony\Component\Validator\Constraints as Assert;
use App\Dto\AnswerDto;

class QuizzResultDto
{

    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    public int $quizzId;


    /**
     * @var AnswerDto[]
     */
    #[Assert\NotNull]
    #[Assert\Count(min: 1)]
    public $answers;

    public function getQuizzId(): int
    {
        return $this->quizzId;
    }

    public function setQuizzId(int $quizzId): self
    {
        $this->quizzId = $quizzId;

        return $this;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): self
    {
        $this->answers = $answers;

        return $this;
    }
}