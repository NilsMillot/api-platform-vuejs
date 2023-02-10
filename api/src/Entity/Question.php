<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 500)]
    private ?string $firstAnswer = null;

    #[ORM\Column(length: 500)]
    private ?string $secondAnswer = null;

    #[ORM\Column]
    private ?int $correctAnswer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstAnswer(): ?string
    {
        return $this->firstAnswer;
    }

    public function setFirstAnswer(string $firstAnswer): self
    {
        $this->firstAnswer = $firstAnswer;

        return $this;
    }

    public function getSecondAnswer(): ?string
    {
        return $this->secondAnswer;
    }

    public function setSecondAnswer(string $secondAnswer): self
    {
        $this->secondAnswer = $secondAnswer;

        return $this;
    }

    public function getCorrectAnswer(): ?int
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(int $correctAnswer): self
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }
}
