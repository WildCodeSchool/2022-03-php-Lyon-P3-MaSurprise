<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private string $orderStatus = "Commande créée";

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $collectDate;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ordersToSellers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $buyer;

    // TODO : move this from here to OrderLine, somehow
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ordersFromBuyers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $seller;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'orderFromBuyer')]
    #[ORM\JoinColumn(nullable: false)]
    private Address $billingAddress;

    // TODO : move this from here to OrderLine, somehow
    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'orderFromSeller')]
    #[ORM\JoinColumn(nullable: false)]
    private Address $deliveryAddress;

    #[ORM\Column(type: 'float')]
    private float $total;

    #[ORM\OneToMany(mappedBy: 'orderReference', targetEntity: OrderLine::class, cascade: ['persist', 'remove'])]
    private Collection $orderLines;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
    }

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

    public function getCollectDate(): ?DateTimeInterface
    {
        return $this->collectDate;
    }

    public function setCollectDate(?DateTimeInterface $collectDate): self
    {
        $this->collectDate = $collectDate;

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

    public function getBillingAddress(): ?Address
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?Address $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): self
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines[] = $orderLine;
            $orderLine->setOrderReference($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getOrderReference() === $this) {
                $orderLine->setOrderReference(null);
            }
        }

        return $this;
    }
}
