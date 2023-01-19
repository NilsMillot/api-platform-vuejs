<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column]
    private ?int $totalCredits = null;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: MovieScreening::class)]
    private Collection $movieScreenings;

    #[ORM\OneToMany(mappedBy: 'buyer', targetEntity: MovieInstance::class)]
    private Collection $movieInstances;

    public function __construct()
    {
        $this->movieScreenings = new ArrayCollection();
        $this->movieInstances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getTotalCredits(): ?int
    {
        return $this->totalCredits;
    }

    public function setTotalCredits(int $totalCredits): self
    {
        $this->totalCredits = $totalCredits;

        return $this;
    }

    /**
     * @return Collection<int, MovieScreening>
     */
    public function getMovieScreenings(): Collection
    {
        return $this->movieScreenings;
    }

    public function addMovieScreening(MovieScreening $movieScreening): self
    {
        if (!$this->movieScreenings->contains($movieScreening)) {
            $this->movieScreenings->add($movieScreening);
            $movieScreening->setCreator($this);
        }

        return $this;
    }

    public function removeMovieScreening(MovieScreening $movieScreening): self
    {
        if ($this->movieScreenings->removeElement($movieScreening)) {
            // set the owning side to null (unless already changed)
            if ($movieScreening->getCreator() === $this) {
                $movieScreening->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovieInstance>
     */
    public function getMovieInstances(): Collection
    {
        return $this->movieInstances;
    }

    public function addMovieInstance(MovieInstance $movieInstance): self
    {
        if (!$this->movieInstances->contains($movieInstance)) {
            $this->movieInstances->add($movieInstance);
            $movieInstance->setBuyer($this);
        }

        return $this;
    }

    public function removeMovieInstance(MovieInstance $movieInstance): self
    {
        if ($this->movieInstances->removeElement($movieInstance)) {
            // set the owning side to null (unless already changed)
            if ($movieInstance->getBuyer() === $this) {
                $movieInstance->setBuyer(null);
            }
        }

        return $this;
    }
}
