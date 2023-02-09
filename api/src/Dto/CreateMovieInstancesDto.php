<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateMovieInstancesDto
{
    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    private int $movieId;

    #[Assert\LessThan(1000)]
    private int $quantity;

    #[Assert\GreaterThan(0)]
    private float $price;

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @param int $movieId
     */
    public function setMovieId(int $movieId): void
    {
        $this->movieId = $movieId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}