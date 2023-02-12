<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use App\Controller\EnableAccountController;
use App\Controller\ResetPasswordController;
use App\Controller\ResetPasswordRequestController;
use App\Dto\EnableAccountDto;
use App\Dto\ResetPasswordDto;
use App\Dto\ResetPasswordRequestDto;
use App\Dto\SignupDto;
use App\Dto\UpdateUserDto;
use App\Dto\SignupAdminDto;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Patch;
use App\Controller\SignupController;
use App\Controller\SignupAdminController;
use App\Controller\DeleteUserController;
use App\Controller\UpdateUserController;
use App\Controller\CurrentUserController;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/users/{id}',
        // Only if current user is admin or current user is the user that is being fetched
        security: 'is_granted("ROLE_ADMIN") or object == user',
        openapiContext: ['description' => 'Get an account'],
        normalizationContext: ['groups' => ['user:read']]
    ),
    new GetCollection(
        // security: 'is_granted("ROLE_ADMIN")',
        normalizationContext: ['groups' => ['getCollection:read']]
    ),
    new Put(
        uriTemplate: '/enable_account/{id}',
        controller: EnableAccountController::class,
        openapiContext: ['description' => 'Enable an account'],
        input: EnableAccountDto::class
    ),
    new Post(
        uriTemplate: '/signup',
        controller: SignupController::class,
        openapiContext: ['description' => 'Register an account'],
        input: SignupDto::class
    ),
    new Post(
        security: 'is_granted("ROLE_ADMIN")',
        securityMessage: 'Only admins can access this route',
        uriTemplate: '/signupadmin',
        controller: SignupAdminController::class,
        openapiContext: ['description' => 'Register an account when you are an admin'],
        input: SignupAdminDto::class
    ),
    new Delete(
        security: 'is_granted("ROLE_ADMIN")',
        securityMessage: 'Only admins can access this route',
        uriTemplate: '/users/{id}',
        controller: DeleteUserController::class,
        openapiContext: ['description' => 'Delete an account'],
    ),
    // Everyone can call this route but only admins can update roles and totalCredits for another user
    new Put(
        uriTemplate: '/users/{id}',
        controller: UpdateUserController::class,
        openapiContext: ['description' => 'Update an account'],
        input: UpdateUserDto::class
    ),
    // Call this route when you want to get the current user
    new GetCollection(
        uriTemplate: '/me',
        controller: CurrentUserController::class,
        openapiContext: ['description' => 'Get current user']
    ),
    new Post(
        uriTemplate: '/reset_password_request',
        controller: ResetPasswordRequestController::class,
        openapiContext: ['summary' => 'Send mail to reset password'],
        input: ResetPasswordRequestDto::class
    ),
    new Post(
        uriTemplate: '/reset_password',
        controller: ResetPasswordController::class,
        openapiContext: ['summary' => 'Reset password'],
        input: ResetPasswordDto::class
    ),
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['session:read', 'getCollection:read', 'user:read'])]
    private ?int $id = null;

    #[Groups(['user:read', 'getCollection:read', 'session:read','quizz-result:read'])]
    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    private ?string $email = null;

    #[Groups(['user:read', 'getCollection:read'])]
    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'getCollection:read'])]
    private ?string $adress = null;
    
    #[ORM\Column]
    private ?int $totalCredits = 0;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: MovieScreening::class)]
    private Collection $movieScreenings;

    #[ORM\OneToMany(mappedBy: 'buyer', targetEntity: MovieInstance::class)]
    private Collection $movieInstances;

    #[ORM\Column]
    #[Groups(['user:read', 'getCollection:read'])]
    private ?bool $enabled = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $confirmationToken = null;

    #[Groups(['user:read', 'getCollection:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read','session:read', 'getCollection:read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'buyer_id', targetEntity: Booking::class)]
    private Collection $bookings;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resetPasswordToken = null;

    #[ORM\OneToMany(mappedBy: 'participant', targetEntity: QuizzResult::class, orphanRemoval: true)]
    private Collection $quizzResults;

    public function __construct()
    {
        $this->movieScreenings = new ArrayCollection();
        $this->movieInstances = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->quizzResults = new ArrayCollection();
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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setBuyerId($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getBuyerId() === $this) {
                $booking->setBuyerId(null);
            }
        }

        return $this;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken): self
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

    /**
     * @return Collection<int, QuizzResult>
     */
    public function getQuizzResults(): Collection
    {
        return $this->quizzResults;
    }

    public function addQuizzResult(QuizzResult $quizzResult): self
    {
        if (!$this->quizzResults->contains($quizzResult)) {
            $this->quizzResults->add($quizzResult);
            $quizzResult->setParticipant($this);
        }

        return $this;
    }

    public function removeQuizzResult(QuizzResult $quizzResult): self
    {
        if ($this->quizzResults->removeElement($quizzResult)) {
            // set the owning side to null (unless already changed)
            if ($quizzResult->getParticipant() === $this) {
                $quizzResult->setParticipant(null);
            }
        }

        return $this;
    }
}
