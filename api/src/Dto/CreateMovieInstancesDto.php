<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateMovieInstancesDto
{
    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    private int $tmdbMovieId;

    #[Assert\GreaterThan(0)]
    #[Assert\LessThan(1000)]
    private int $quantity;

    /**
     * @return int
     */
    public function getTmdbMovieId(): int
    {
        return $this->tmdbMovieId;
    }

    /**
     * @param int $tmdbMovieId
     */
    public function setTmdbMovieId(int $tmdbMovieId): void
    {
        $this->tmdbMovieId = $tmdbMovieId;
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