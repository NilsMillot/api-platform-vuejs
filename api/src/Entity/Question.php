<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource(operations: [
    new GetCollection(
        security: 'is_granted("ROLE_ADMIN")',
        normalizationContext: ['groups' => ['questions-admin:read']]
    ),
    new Post(
        security: 'is_granted("ROLE_ADMIN")',
    ),
    new Delete(
        security: 'is_granted("ROLE_ADMIN")',
    ),
])]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quizz:read','questions-admin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quizz:read','questions-admin:read'])]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 500)]
    #[Groups(['quizz:read','questions-admin:read'])]
    #[Assert\NotBlank]
    private ?string $firstAnswer = null;

    #[ORM\Column(length: 500)]
    #[Groups(['quizz:read','questions-admin:read'])]
    #[Assert\NotBlank]
    private ?string $secondAnswer = null;

    #[ORM\Column]
    #[Assert\Choice([1, 2])]
    #[Groups(['questions-admin:read'])]
    private ?int $correctAnswer = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['questions-admin:read'])]
    private ?Quizz $quizz = null;

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

    public function getQuizz(): ?Quizz
    {
        return $this->quizz;
    }

    public function setQuizz(?Quizz $quizz): self
    {
        $this->quizz = $quizz;

        return $this;
    }
}
