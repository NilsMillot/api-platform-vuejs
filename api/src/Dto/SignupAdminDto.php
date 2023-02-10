<?php

namespace App\Dto;

use App\Validators\UniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

class SignupAdminDto
{
    #[Assert\Email]
    #[UniqueEmail]
    public string $email;
    
    #[Assert\NotBlank]
    public string $adress;

    #[Assert\NotNull]
    public bool $isCinema;
    #[Assert\NotNull]
    public bool $isAdmin;

    #[Assert\Null]
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
    public function getAdress(): string
    {
        return $this->adress;
    }

    /**
     * @param string $adress
     */
    public function setAdress(string $adress): void
    {
        $this->adress = $adress;
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
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(string $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
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
}