<?php

namespace App\Dto;

use App\Validators\UniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

class SignupDto
{
    #[Assert\Email]
    #[UniqueEmail]
    public string $email;
    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    public string $password;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    #[Assert\EqualTo(propertyPath: 'password', message: 'Les mots de passe ne correspondent pas')]
    public string $passwordConfirm;

    #[Assert\NotNull]
    public bool $isCinema;

    public string $name;


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

     /**
     * @return bool
     */
    public function getIsCinema(): bool
    {
        return $this->isCinema;
    }

    /**
     * @param bool $isCinema
     */
    public function setIsCinema(string $isCinema): void
    {
        $this->isCinema = $isCinema;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPasswordConfirm(): string
    {
        return $this->passwordConfirm;
    }

    /**
     * @param string $passwordConfirm
     */
    public function setPasswordConfirm(string $passwordConfirm): void
    {
        $this->passwordConfirm = $passwordConfirm;
    }
}