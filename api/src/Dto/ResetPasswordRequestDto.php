<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Email(message: 'Email invalide')]
    private string $email;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}