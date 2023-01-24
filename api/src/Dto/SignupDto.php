<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class SignupDto
{
    #[Assert\Email]
    public string $email;
    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    public string $password;

    #[Assert\NotBlank]
    public string $adress;
    #[Assert\NotBlank]
    public string $status;

    #[Assert\NotNull]
    public bool $isCinema;

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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
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
}