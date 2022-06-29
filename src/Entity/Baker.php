<?php

namespace App\Entity;

use DateTime;
use App\Entity\Cake;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BakerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BakerRepository::class)]
#[Vich\Uploadable]
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

    #[ORM\Column(type: 'string', length: 255)]
    private string $phone;

    #[ORM\OneToMany(mappedBy: 'baker', targetEntity: Cake::class, orphanRemoval: true)]
    private Collection $cakes;

    #[ORM\Column(type: 'string', length: 255)]
    private string $bakerType;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $services;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $siret = "";

    #[Vich\UploadableField(mapping: 'siret_file', fileNameProperty: 'siret')]
    #[Assert\File(
        maxSize: '500k',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'],
        mimeTypesMessage: 'Ce fichier doit être une image ou un fichier pdf',
        uploadFormSizeErrorMessage: 'Votre photo ne peut pas dépasser 500Ko'
    )]
    private ?File $siretFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $diploma = "";

    #[Vich\UploadableField(mapping: 'diploma_file', fileNameProperty: 'diploma')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'],
        mimeTypesMessage: 'Ce fichier doit être une image ou un fichier pdf',
        uploadFormSizeErrorMessage: 'Votre photo ne peut pas dépasser 1Mo'
    )]
    private ?File $diplomaFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $logo = "";

    #[Vich\UploadableField(mapping: 'logo_file', fileNameProperty: 'logo')]
    #[Assert\File(
        maxSize: '500k',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        mimeTypesMessage: 'Ce fichier doit être une image',
        uploadFormSizeErrorMessage: 'Votre photo ne peut pas dépasser 500Ko'
    )]
    private ?File $logoFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $facebook;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $instagram;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\OneToOne(mappedBy: 'deliveryAddress', targetEntity: Address::class, cascade: ['persist', 'remove'])]
    private $deliveryAddress;

    #[ORM\OneToOne(mappedBy: 'baker', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    public function __construct()
    {
        $this->cakes = new ArrayCollection();
        $this->created = new DateTime();
        $this->addresses = new ArrayCollection();
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

    public function getBakerType(): ?string
    {
        return $this->bakerType;
    }

    public function setBakerType(string $bakerType): self
    {
        $this->bakerType = $bakerType;

        return $this;
    }

    public function getServices(): ?string
    {
        return $this->services;
    }

    public function setServices(?string $services): self
    {
        $this->services = $services;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function setSiretFile(?File $siretFile = null): void
    {
        $this->siretFile = $siretFile;

        if (null !== $siretFile) {
            $this->getUpdateAt();
        }
    }

    public function getSiretFile(): ?File
    {
        return $this->siretFile;
    }

    public function getDiploma(): ?string
    {
        return $this->diploma;
    }

    public function setDiploma(?string $diploma): self
    {
        $this->diploma = $diploma;

        return $this;
    }

    public function setDiplomaFile(?File $diplomaFile = null): void
    {
        $this->diplomaFile = $diplomaFile;

        if (null !== $diplomaFile) {
            $this->getUpdateAt();
        }
    }

    public function getDiplomaFile(): ?File
    {
        return $this->diplomaFile;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
            $this->getUpdateAt();
        }
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

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

    public function getDeliveryAddress(): ?Address
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(Address $deliveryAddress): self
    {
        // set the owning side of the relation if necessary
        if ($deliveryAddress->getDeliveryAddress() !== $this) {
            $deliveryAddress->setDeliveryAddress($this);
        }

        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setBaker(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getBaker() !== $this) {
            $user->setBaker($this);
        }

        $this->user = $user;

        return $this;
    }
}
