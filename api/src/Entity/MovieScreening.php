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

    #[ORM\Column(type: Types::ARRAY)]
    private array $disposition_room = [];

    #[ORM\ManyToOne(inversedBy: 'movieScreenings')]
    private ?User $creator = null;

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

    public function getDispositionRoom(): array
    {
        return $this->disposition_room;
    }

    public function setDispositionRoom(array $disposition_room): self
    {
        $this->disposition_room = $disposition_room;

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
}
