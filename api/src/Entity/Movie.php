<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $genre = [];

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName('poster_path')]
    private ?string $posterPath = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName('backdrop_path')]
    private ?string $backdropPath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?bool $video = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('vote_average')]
    private ?float $voteAverage = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('vote_count')]
    private ?int $voteCount = null;

    #[ORM\Column(nullable: true)]
    private ?int $runtime = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName('release_date')]
    private ?string $releaseDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName('original_language')]
    private ?string $originalLanguage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName('original_title')]
    private ?string $originalTitle = null;

    #[ORM\Column(length: 10000, nullable: true)]
    #[SerializedName('overview')]
    private ?string $overview = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: MovieInstance::class, orphanRemoval: true)]
    private Collection $movieInstances;

    #[ORM\Column(nullable: true)]
    private ?float $popularity = null;

    #[ORM\Column]
    private ?int $quantity = 0;

    public function __construct()
    {
        $this->movieInstances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getGenre(): array
    {
        return $this->genre;
    }

    public function setGenre(array $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->posterPath;
    }

    public function setPosterPath(?string $posterPath): self
    {
        $this->posterPath = $posterPath;

        return $this;
    }

    public function getBackdropPath(): ?string
    {
        return $this->backdropPath;
    }

    public function setBackdropPath(?string $backdropPath): self
    {
        $this->backdropPath = $backdropPath;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isVideo(): ?bool
    {
        return $this->video;
    }

    public function setVideo(bool $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getVoteAverage(): ?float
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(float $voteAverage): self
    {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    public function getVoteCount(): ?int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function getRuntime(): ?int
    {
        return $this->runtime;
    }

    public function setRuntime(?int $runtime): self
    {
        $this->runtime = $runtime;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getOriginalLanguage(): ?string
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(string $originalLanguage): self
    {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(string $originalTitle): self
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * @return Collection<int, MovieInstance>
     */
    public function getMovieInstances(): Collection
    {
        return $this->movieInstances;
    }

    public function addMovieInstance(MovieInstance $movieInstance): self
    {
        if (!$this->movieInstances->contains($movieInstance)) {
            $this->movieInstances[] = $movieInstance;
            $movieInstance->setMovie($this);
        }

        return $this;
    }

    public function getPopularity(): ?float
    {
        return $this->popularity;
    }

    public function setPopularity(?float $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

}