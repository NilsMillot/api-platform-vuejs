<?php

namespace App\Dto;

// use App\Validators\UniqueEmail;
// use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDto
{
    // adress can be undefined
    public string $adress;
    public string $status;
    public string $name;
    public array $roles;
    public int $totalCredits;

    /**
     * @return int
     */
    public function getTotalCredits(): int
    {
        return $this->totalCredits;
    }

    /**
     * @param int $totalCredits
     */
    public function setTotalCredits(int $totalCredits): void
    {
        $this->totalCredits = $totalCredits;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
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