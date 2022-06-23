<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Faker\Core\Number;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'buyer', targetEntity: Order::class)]
    private Collection $ordersToSellers;

    #[ORM\OneToMany(mappedBy: 'seller', targetEntity: Order::class)]
    private Collection $ordersFromBuyers;

    public function __construct()
    {
        $this->ordersToSellers = new ArrayCollection();
        $this->ordersFromBuyers = new ArrayCollection();
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
        return (string)$this->email;
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
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrdersToSellers(): Collection
    {
        return $this->ordersToSellers;
    }

    public function addOrdersToSeller(Order $ordersToSeller): self
    {
        if (!$this->ordersToSellers->contains($ordersToSeller)) {
            $this->ordersToSellers[] = $ordersToSeller;
            $ordersToSeller->setBuyer($this);
        }

        return $this;
    }

    public function removeOrdersToSeller(Order $ordersToSeller): self
    {
        if ($this->ordersToSellers->removeElement($ordersToSeller)) {
            // set the owning side to null (unless already changed)
            if ($ordersToSeller->getBuyer() === $this) {
                $ordersToSeller->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrdersFromBuyers(): Collection
    {
        return $this->ordersFromBuyers;
    }

    public function addOrdersFromBuyer(Order $ordersFromBuyer): self
    {
        if (!$this->ordersFromBuyers->contains($ordersFromBuyer)) {
            $this->ordersFromBuyers[] = $ordersFromBuyer;
            $ordersFromBuyer->setSeller($this);
        }

        return $this;
    }

    public function removeOrdersFromBuyer(Order $ordersFromBuyer): self
    {
        if ($this->ordersFromBuyers->removeElement($ordersFromBuyer)) {
            // set the owning side to null (unless already changed)
            if ($ordersFromBuyer->getSeller() === $this) {
                $ordersFromBuyer->setSeller(null);
            }
        }

        return $this;
    }
}
