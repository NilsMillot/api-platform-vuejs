<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class EnableAccountDto
{

    #[Assert\NotBlank]
    public string $token = '';

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}