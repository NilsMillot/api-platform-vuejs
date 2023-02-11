<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use App\Repository\QuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuizzRepository::class)]
#[ApiResource(operations: [
    new GetCollection(
        uriTemplate: '/quizzs',
        normalizationContext: ['groups' => ['quizz-list:read']]
    ),

    new Put(),
    new Post(),
    new Get(
        normalizationContext: ['groups' => ['quizz-list:read']],
        security: 'is_granted("ROLE_USER") or is_granted("ROLE_ADMIN") or is_granted("CINEMA")',
    ),
    new Get(
        uriTemplate: '/quizzs/{id}',
        normalizationContext: ['groups' => ['quizz:read']],
        security: 'is_granted("ROLE_USER") or is_granted("ROLE_ADMIN") or is_granted("CINEMA")',
    )
])]
class Quizz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quizz-list:read', 'quizz:read','questions-admin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['quizz-list:read', 'quizz:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan("today", message:"La date doit être supérieure à la date d'aujourd'hui")]
    #[Groups(['quizz-list:read'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'quizz', targetEntity: Question::class, orphanRemoval: true)]
    #[Groups(['quizz:read'])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

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

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuizz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuizz() === $this) {
                $question->setQuizz(null);
            }
        }

        return $this;
    }
}
