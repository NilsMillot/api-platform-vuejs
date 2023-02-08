<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateMovieInstancesDto
{
    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    private int $movieId;

    #[Assert\GreaterThan(0)]
    #[Assert\LessThan(1000)]
    private int $quantity;

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
}