<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FamilleRepository::class)
 * @Vich\Uploadable
 */
class Famille
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $famille;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $coverImage;

    /**
     * @Vich\UploadableField(mapping="famille_images", fileNameProperty="coverImage")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=SousFamille::class, mappedBy="famille")
     * @ORM\OrderBy({"norder" = "DESC"})
     */
    private $sousFamilles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $norder;

    public function __construct()
    {
        $this->sousFamilles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamille(): ?string
    {
        return $this->famille;
    }

    public function setFamille(string $famille): self
    {
        $this->famille = $famille;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * @return Collection|\App\Entity\SousFamille[]
     */
    public function getSousFamilles(): Collection
    {
        return $this->sousFamilles;
    }

    public function addSousFamille(\App\Entity\SousFamille $sousFamille): self
    {
        if (!$this->sousFamilles->contains($sousFamille)) {
            $this->sousFamilles[] = $sousFamille;
            $sousFamille->setFamille($this);
        }

        return $this;
    }

    public function removeSousFamille(\App\Entity\SousFamille $sousFamille): self
    {
        if ($this->sousFamilles->contains($sousFamille)) {
            $this->sousFamilles->removeElement($sousFamille);
            // set the owning side to null (unless already changed)
            if ($sousFamille->getFamille() === $this) {
                $sousFamille->setFamille(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function __toString()
    {
        return (string)$this->getFamille();
    }

    public function getNorder(): ?int
    {
        return $this->norder;
    }

    public function setNorder(?int $norder): self
    {
        $this->norder = $norder;

        return $this;
    }

}
