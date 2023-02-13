<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MovieOrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovieOrderRepository::class)]
#[ApiResource(operations: [
    new GetCollection(
        normalizationContext: [
            'groups' => ['movieOrderList:read']
        ],
        security: 'is_granted("ROLE_ADMIN")'
    )
])]
class MovieOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'movieOrders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['movieOrderList:read'])]
    private ?User $buyer = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movieOrderList:read'])]
    private ?string $movieName = null;

    #[ORM\Column]
    #[Groups(['movieOrderList:read'])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['movieOrderList:read'])]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMovieName(): ?string
    {
        return $this->movieName;
    }

    public function setMovieName(string $movieName): self
    {
        $this->movieName = $movieName;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
