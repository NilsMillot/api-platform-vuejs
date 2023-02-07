<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieScreeningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieScreeningRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['session:read']],
)]
class MovieScreening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['session:read'])]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['session:read'])]
    #[Assert\GreaterThan("today", message:"La date doit être supérieure à la date d'aujourd'hui")]
    private ?\DateTimeInterface $session_datetime = null;

    #[ORM\Column]
    #[Groups(['session:read'])]
    #[Assert\NotNull]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'movieScreenings')]
    #[Groups(['session:read'])]
    private ?User $creator = null;

    #[ORM\Column]
    #[Groups(['session:read'])]
    private ?int $room = null;

    #[ORM\Column]
    #[Groups(['session:read'])]
    private ?int $movie_id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['session:read'])]
    private ?string $movie_title = null;

    #[ORM\OneToMany(mappedBy: 'session_id', targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setSessionId($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getSessionId() === $this) {
                $booking->setSessionId(null);
            }
        }

        return $this;
    }
}
