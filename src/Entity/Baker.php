<?php

namespace App\Entity;

use DateTime;
use App\Entity\Cake;
use App\Entity\Department;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BakerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BakerRepository::class)]
class Baker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $commercialName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address;

    #[ORM\Column(type: 'string', length: 255)]
    private string $phone;

    #[ORM\OneToMany(mappedBy: 'baker', targetEntity: Cake::class, orphanRemoval: true)]
    private Collection $cakes;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $streetNumber;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private string $bisTerInfo;

    #[ORM\Column(type: 'string', length: 100)]
    private string $streetName;

    #[ORM\Column(type: 'integer')]
    private int $postcode;

    #[ORM\Column(type: 'string', length: 100)]
    private string $city;

    #[ORM\ManyToOne(targetEntity: Department::class, inversedBy: 'bakers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private string $extraInfo;

    public function __construct()
    {
        $this->cakes = new ArrayCollection();
        $this->created = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }

    public function setCommercialName(?string $commercialName): self
    {
        $this->commercialName = $commercialName;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Cake>
     */
    public function getCakes(): Collection
    {
        return $this->cakes;
    }

    public function addCake(Cake $cake): self
    {
        if (!$this->cakes->contains($cake)) {
            $this->cakes[] = $cake;
            $cake->setBaker($this);
        }

        return $this;
    }

    public function removeCake(Cake $cake): self
    {
        if ($this->cakes->removeElement($cake)) {
            // set the owning side to null (unless already changed)
            if ($cake->getBaker() === $this) {
                $cake->setBaker(null);
            }
        }

        return $this;
    }

    // gets the fullname and displays it inside the form: CakeType
    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
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
        $this->$bisTerInfo = $bisTerInfo;

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
}
