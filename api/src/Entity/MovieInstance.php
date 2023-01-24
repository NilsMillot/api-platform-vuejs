<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateMovieInstancesController;
use App\Dto\CreateMovieInstancesDto;
use App\Repository\MovieInstanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieInstanceRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new GetCollection(),
    new Post(
        uriTemplate: '/movie-instances',
        controller: CreateMovieInstancesController::class,
        openapiContext: ['description' => 'Create multiple movie instances of a movie'],
        input: CreateMovieInstancesDto::class,
    ),
])]
class MovieInstance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $buyedDate = null;

    #[ORM\ManyToOne(inversedBy: 'movieInstances')]
    private ?User $buyer = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'movieInstances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $movie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyedDate(): ?\DateTimeInterface
    {
        return $this->buyedDate;
    }

    public function setBuyedDate(?\DateTimeInterface $buyedDate): self
    {
        $this->buyedDate = $buyedDate;

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }
}
