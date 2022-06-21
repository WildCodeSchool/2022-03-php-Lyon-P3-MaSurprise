<?php

namespace App\Entity;

use App\Entity\Baker;
use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 3)]
    private string $number;

    #[ORM\Column(type: 'string', length: 50)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Baker::class)]
    private ?Collection $bakers;

    #[ORM\OneToMany(mappedBy: 'department1', targetEntity: Address::class)]
    private $addresses;

    #[ORM\OneToMany(mappedBy: 'department2', targetEntity: Address::class)]
    private $extraInfo2;

    public function __construct()
    {
        $this->bakers = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->extraInfo2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDisplayName(): string
    {
        return $this->number . ' - ' . $this->name;
    }

    /**
     * @return Collection<int, Baker>
     */
    public function getBakers(): Collection
    {
        return $this->bakers;
    }

    public function addBaker(Baker $baker): self
    {
        if (!$this->bakers->contains($baker)) {
            $this->bakers[] = $baker;
            $baker->setDepartment($this);
        }

        return $this;
    }

    public function removeBaker(Baker $baker): self
    {
        if ($this->bakers->removeElement($baker)) {
            // set the owning side to null (unless already changed)
            if ($baker->getDepartment() === $this) {
                $baker->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setDepartment1($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getDepartment1() === $this) {
                $address->setDepartment1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getExtraInfo2(): Collection
    {
        return $this->extraInfo2;
    }

    public function addExtraInfo2(Address $extraInfo2): self
    {
        if (!$this->extraInfo2->contains($extraInfo2)) {
            $this->extraInfo2[] = $extraInfo2;
            $extraInfo2->setDepartment2($this);
        }

        return $this;
    }

    public function removeExtraInfo2(Address $extraInfo2): self
    {
        if ($this->extraInfo2->removeElement($extraInfo2)) {
            // set the owning side to null (unless already changed)
            if ($extraInfo2->getDepartment2() === $this) {
                $extraInfo2->setDepartment2(null);
            }
        }

        return $this;
    }
}
