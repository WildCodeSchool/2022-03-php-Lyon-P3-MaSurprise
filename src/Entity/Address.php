<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $streetNumber;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private ?string $bisTerInfo;

    #[ORM\Column(type: 'string', length: 100)]
    private string $streetName;

    #[ORM\Column(type: 'integer')]
    private int $postcode;

    #[ORM\Column(type: 'string', length: 100)]
    private string $city;

    #[ORM\ManyToOne(targetEntity: Department::class, inversedBy: 'addresses')]
    #[ORM\JoinColumn(nullable: false)]
    private Department $department;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $extraInfo;

    #[ORM\OneToOne(inversedBy: 'deliveryAddress', targetEntity: Baker::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Baker $deliveryAddress;

    #[ORM\Column(type: 'boolean')]
    private bool $status = true;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'remove'], inversedBy: 'billingAddress')]
    private ?User $billingAddress;

    #[ORM\OneToMany(mappedBy: 'billingAddress', targetEntity: Order::class)]
    private Collection $orderFromBuyer;

    #[ORM\OneToMany(mappedBy: 'deliveryAddress', targetEntity: Order::class)]
    private Collection $orderFromSeller;

    public function __construct()
    {
        $this->orderFromBuyer = new ArrayCollection();
        $this->orderFromSeller = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
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

    public function getDeliveryAddress(): ?Baker
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Baker $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBillingAddress(): ?User
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?User $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderFromBuyer(): Collection
    {
        return $this->orderFromBuyer;
    }

    public function addOrderFromBuyer(Order $orderFromBuyer): self
    {
        if (!$this->orderFromBuyer->contains($orderFromBuyer)) {
            $this->orderFromBuyer[] = $orderFromBuyer;
            $orderFromBuyer->setBillingAddress($this);
        }

        return $this;
    }

    public function removeOrderFromBuyer(Order $orderFromBuyer): self
    {
        if ($this->orderFromBuyer->removeElement($orderFromBuyer)) {
            // set the owning side to null (unless already changed)
            if ($orderFromBuyer->getBillingAddress() === $this) {
                $orderFromBuyer->setBillingAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderFromSeller(): Collection
    {
        return $this->orderFromSeller;
    }

    public function addOrderFromSeller(Order $orderFromSeller): self
    {
        if (!$this->orderFromSeller->contains($orderFromSeller)) {
            $this->orderFromSeller[] = $orderFromSeller;
            $orderFromSeller->setDeliveryAddress($this);
        }

        return $this;
    }

    public function removeOrderFromSeller(Order $orderFromSeller): self
    {
        if ($this->orderFromSeller->removeElement($orderFromSeller)) {
            // set the owning side to null (unless already changed)
            if ($orderFromSeller->getDeliveryAddress() === $this) {
                $orderFromSeller->setDeliveryAddress(null);
            }
        }

        return $this;
    }
}
