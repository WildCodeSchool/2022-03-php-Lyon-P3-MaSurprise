<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $orderedAt;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $orderStatus;

    #[ORM\Column(type: 'string', length: 255)]
    private string $cakeName;

    #[ORM\Column(type: 'float')]
    private float $cakePrice;

    #[ORM\Column(type: 'string', length: 255)]
    private string $cakeSize;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $streetNumber;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private ?string $bisTerInfo;

    #[ORM\Column(type: 'string', length: 255)]
    private string $streetName;

    #[ORM\Column(type: 'integer')]
    private int $postcode;

    #[ORM\Column(type: 'string', length: 100)]
    private string $city;

    #[ORM\Column(type: 'string', length: 3)]
    private string $department;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $extraInfo;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $collectDate;

    #[ORM\Column(type: 'boolean')]
    private bool $orderValidated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ordersToSellers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $buyer;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ordersFromBuyers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $seller;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderedAt(): ?DateTimeInterface
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(DateTimeInterface $orderedAt): self
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    public function getCakeName(): ?string
    {
        return $this->cakeName;
    }

    public function setCakeName(string $cakeName): self
    {
        $this->cakeName = $cakeName;

        return $this;
    }

    public function getCakeSize(): ?string
    {
        return $this->cakeSize;
    }

    public function setCakeSize(string $cakeSize): self
    {
        $this->cakeSize = $cakeSize;

        return $this;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getBisTerInfo(): ?string
    {
        return $this->bisTerInfo;
    }

    public function setBisTerInfo(?string $bisTerInfo): self
    {
        $this->bisTerInfo = $bisTerInfo;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getExtraInfo(): ?string
    {
        return $this->extraInfo;
    }

    public function setExtraInfo(?string $extraInfo): self
    {
        $this->extraInfo = $extraInfo;

        return $this;
    }

    public function getCakePrice(): ?float
    {
        return $this->cakePrice;
    }

    public function setCakePrice(float $cakePrice): self
    {
        $this->cakePrice = $cakePrice;

        return $this;
    }

    public function getCollectDate(): ?DateTimeInterface
    {
        return $this->collectDate;
    }

    public function setCollectDate(?DateTimeInterface $collectDate): self
    {
        $this->collectDate = $collectDate;

        return $this;
    }

    public function isOrderValidated(): ?bool
    {
        return $this->orderValidated;
    }

    public function setOrderValidated(bool $orderValidated): self
    {
        $this->orderValidated = $orderValidated;

        return $this;
    }

    public function getOrderStatus(): ?string
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): self
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $seller): self
    {
        $this->seller = $seller;

        return $this;
    }
}
