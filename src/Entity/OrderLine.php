<?php

namespace App\Entity;

use App\Repository\OrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderLineRepository::class)]
class OrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Order::class, cascade: ['persist', 'remove'], inversedBy: 'orderLines')]
    #[ORM\JoinColumn(nullable: false)]
    private Order $orderReference;

    #[ORM\Column(type: 'string', length: 255)]
    private string $cakeName;

    #[ORM\Column(type: 'float')]
    private float $cakePrice;

    #[ORM\Column(type: 'string', length: 255)]
    private string $cakeSize;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ordersFromBuyers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $seller;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'orderFromSeller')]
    #[ORM\JoinColumn(nullable: false)]
    private Address $deliveryAddress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderReference(): ?Order
    {
        return $this->orderReference;
    }

    public function setOrderReference(?Order $orderReference): self
    {
        $this->orderReference = $orderReference;

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

    public function getCakePrice(): ?float
    {
        return $this->cakePrice;
    }

    public function setCakePrice(float $cakePrice): self
    {
        $this->cakePrice = $cakePrice;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getDeliveryAddress(): ?Address
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Address $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }
}
