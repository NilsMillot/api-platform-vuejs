<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateMovieInstancesController;
use App\Controller\GetMovieInstancesController;
use App\Dto\CreateMovieInstancesDto;
use App\Repository\MovieInstanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovieInstanceRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new GetCollection(
        controller: GetMovieInstancesController::class,
        openapiContext: [
            'summary' => 'Get movie instances of a movie',
            'description' => 'Get movie instances of a movie',
            'parameters' => [
                [
                    'name' => 'movie',
                    'in' => 'query',
                    'description' => 'The movie id',
                    'required' => true,
                    'schema' => [
                        'type' => 'integer',
                    ],
                ],
                [
                    'name' => 'available',
                    'in' => 'query',
                    'description' => 'filters only not buyed movie',
                    'required' => false,
                    'schema' => [
                        'type' => 'boolean',
                    ],
                ],
            ],
        ],
    ),
    new Post(
        uriTemplate: '/movie_instances',
        controller: CreateMovieInstancesController::class,
        openapiContext: ['description' => 'Create multiple movie instances of a movie'],
        security: 'is_granted("ROLE_ADMIN")',
        input: CreateMovieInstancesDto::class
    ),
])]
#[ApiFilter(SearchFilter::class, properties: ['movie' => 'exact'])]
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
    #[Groups(['movie:read'])]
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
