<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordDto
{
    #[Assert\NotBlank]
    private string $resetPasswordToken;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    private string $password;

    #[Assert\NotBlank]
    #[Assert\EqualTo(propertyPath: 'password', message: 'Les mots de passe ne correspondent pas')]
    private string $passwordConfirm;

    public function getResetPasswordToken(): string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(string $resetPasswordToken): void
    {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPasswordConfirm(): string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(string $passwordConfirm): void
    {
        $this->passwordConfirm = $passwordConfirm;
    }
}