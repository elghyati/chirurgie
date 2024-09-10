<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 * @Vich\Uploadable
 */
class Brand {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $logo;

    /**
     * @Vich\UploadableField(mapping="brand_images", fileNameProperty="logo")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=Famille::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $famille;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Variant::class, mappedBy="brand")
     */
    private $variants;

   

    public function __construct()
    {
        $this->variants = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self {
        $this->libelle = $libelle;

        return $this;
    }

    public function getLogo(): ?string {
        return $this->logo;
    }

    public function setLogo(?string $logo): self {
        $this->logo = $logo;

        return $this;
    }

    public function getFamille(): ?Famille {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): self {
        $this->famille = $famille;

        return $this;
    }

    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile() {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection|Variant[]
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(Variant $variant): self
    {
        if (!$this->variants->contains($variant)) {
            $this->variants[] = $variant;
            $variant->setBrand($this);
        }

        return $this;
    }

    public function removeVariant(Variant $variant): self
    {
        if ($this->variants->contains($variant)) {
            $this->variants->removeElement($variant);
            // set the owning side to null (unless already changed)
            if ($variant->getBrand() === $this) {
                $variant->setBrand(null);
            }
        }

        return $this;
    }

   
}
