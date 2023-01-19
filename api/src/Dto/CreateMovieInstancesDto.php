<?php

namespace App\Dto;

class CreateMovieInstancesDto
{
    private int $tmdbMovieId;
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