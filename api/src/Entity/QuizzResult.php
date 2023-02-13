<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\QuizzResultController;
use App\Dto\QuizzResultDto;
use App\Repository\QuizzResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizzResultRepository::class)]
#[ApiResource(operations: [
    new Post(
        controller: QuizzResultController::class,
        security: 'is_granted("ROLE_USER") and not is_granted("ROLE_ADMIN")',
        input: QuizzResultDto::class,
    ),
    new GetCollection(
        uriTemplate: '/quizz-results',
        security: 'is_granted("ROLE_ADMIN")',
        normalizationContext: ['groups' => ['quizz-result:read']],
    ),
])]
class QuizzResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
   
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizzResults')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['quizz-result:read'])]
    private ?Quizz $quizz = null;

    #[ORM\ManyToOne(inversedBy: 'quizzResults')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['quizz-result:read'])]
    private ?User $participant = null;

    #[ORM\Column]
    #[Groups(['quizz-result:read'])]
    private ?int $score = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParticipant(): ?User
    {
        return $this->participant;
    }

    public function setParticipant(?User $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
