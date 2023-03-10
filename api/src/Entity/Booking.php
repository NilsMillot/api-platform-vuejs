<?php

namespace App\Entity;

use App\Controller\GetBookingsController;
use App\Controller\BookingController;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ApiResource(
    // denormalizationContext: ['groups' => ['booking:write']],
    operations: [
        new GetCollection(),
        new Get(
            uriTemplate: '/seats/{id}',
            controller: GetBookingsController::class,
            security: 'is_granted("ROLE_USER") or is_granted("ROLE_ADMIN") or is_granted("CINEMA")',
            openapiContext: ['description' => 'Get seat'],
        ),
        new Get(),
        // new Post(),
        new Post(
            uriTemplate: '/booking/payment',
            controller: BookingController::class,
            openapiContext: ['description' => 'Payment seat cinema'],
        ),
    ]
)]

class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    // #[Groups(['booking:write'])]
    private ?int $seat = null;

    #[ORM\Column]
    // #[Groups(['booking:write'])]
    private ?int $status = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    // #[Groups(['booking:write'])]
    private ?MovieScreening $session_id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: true)]
    // #[Groups(['booking:write'])]
    private ?User $buyer_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSessionId(): ?MovieScreening
    {
        return $this->session_id;
    }

    public function setSessionId(?MovieScreening $session_id): self
    {
        $this->session_id = $session_id;

        return $this;
    }

    public function getBuyerId(): ?User
    {
        return $this->buyer_id;
    }

    public function setBuyerId(?User $buyer_id): self
    {
        $this->buyer_id = $buyer_id;

        return $this;
    }
}
