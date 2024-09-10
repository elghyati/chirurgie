<?php

namespace App\Entity;

use App\Repository\SousFamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=SousFamilleRepository::class)
 * @Vich\Uploadable
 */
class SousFamille {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $coverImage;

    /**
     * @Vich\UploadableField(mapping="sous_famille_images", fileNameProperty="coverImage")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private $sousFamille;

    /**
     * @ORM\ManyToOne(targetEntity=Famille::class, inversedBy="sousFamilles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $famille;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="sousFamille")
     */
    private $articles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $norder;

    public function __construct() {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getCoverImage(): ?string {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getFamille(): ?Famille {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): self {
        $this->famille = $famille;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection {
        return $this->articles;
    }

    public function addArticle(Article $article): self {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setSousFamille($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getSousFamille() === $this) {
                $article->setSousFamille(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return (string) $this->getSousFamille();
    }

    public function getSousFamille(): ?string {
        return $this->sousFamille;
    }

    public function setSousFamille(string $sousFamille): self {
        $this->sousFamille = $sousFamille;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;
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
