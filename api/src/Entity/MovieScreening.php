<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieScreeningRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieScreeningRepository::class)]
#[ApiResource]
class MovieScreening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $session_datetime = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'movieScreenings')]
    private ?User $creator = null;

    #[ORM\Column]
    private ?int $room = null;

    #[ORM\Column]
    private ?int $movie_id = null;

    #[ORM\Column(length: 255)]
    private ?string $movie_title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionDatetime(): ?\DateTimeInterface
    {
        return $this->session_datetime;
    }

    public function setSessionDatetime(\DateTimeInterface $session_datetime): self
    {
        $this->session_datetime = $session_datetime;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(int $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getMovieId(): ?int
    {
        return $this->movie_id;
    }

    public function setMovieId(int $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    public function getMovieTitle(): ?string
    {
        return $this->movie_title;
    }

    public function setMovieTitle(string $movie_title): self
    {
        $this->movie_title = $movie_title;

        return $this;
    }
}
