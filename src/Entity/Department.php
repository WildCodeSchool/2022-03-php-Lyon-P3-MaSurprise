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

    public function __construct()
    {
        $this->bakers = new ArrayCollection();
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
}
