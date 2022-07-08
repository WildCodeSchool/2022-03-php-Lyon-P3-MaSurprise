<?php

namespace App\Entity;

use App\Repository\CakeRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CakeRepository::class)]
#[Vich\Uploadable]
class Cake
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $picture1 = "";

    #[ORM\Column(type: 'text')]
    private ?string $description;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $allergens;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(type: 'string')]
    private string $size;

    #[ORM\ManyToOne(targetEntity: Baker::class, inversedBy: 'cakes')]
    #[ORM\JoinColumn(nullable: false)]
    private Baker $baker;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $category;

    public function __construct()
    {
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture1(): ?string
    {
        return $this->picture1;
    }

    public function setPicture1(?string $picture1): self
    {
        $this->picture1 = $picture1;

        return $this;
    }

    public function setPicture1File(?File $picture1File = null): void
    {
        $this->picture1File = $picture1File;

        if (null !== $picture1File) {
            $this->getUpdateAt();
        }
    }

    public function getPicture1File(): ?File
    {
        return $this->picture1File;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAllergens(): ?string
    {
        return $this->allergens;
    }

    public function setAllergens(?string $allergens): self
    {
        $this->allergens = $allergens;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getBaker(): ?Baker
    {
        return $this->baker;
    }

    public function setBaker(?Baker $baker): self
    {
        $this->baker = $baker;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }
}
