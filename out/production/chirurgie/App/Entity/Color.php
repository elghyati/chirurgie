<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $hex;

//    /**
//     * @ORM\ManyToMany(targetEntity=ArticleSize::class, inversedBy="colors")
//     */
//    private $article_sizes;



    public function __construct() {
//        $this->article_sizes = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getHex(): ?string {
        return $this->hex;
    }

    public function setHex(?string $hex): self {
        $this->hex = $hex;

        return $this;
    }

    public function __toString(): ?string {
        return $this->name;
    }

//    /**
//     * @return Collection|ArticleSize[]
//     */
//    public function getArticleSizes(): Collection
//    {
//        return $this->article_sizes;
//    }
//
//    public function addArticleSize(ArticleSize $articleSize): self
//    {
//        if (!$this->article_sizes->contains($articleSize)) {
//            $this->article_sizes[] = $articleSize;
//        }
//
//        return $this;
//    }
//
//    public function removeArticleSize(ArticleSize $articleSize): self
//    {
//        if ($this->article_sizes->contains($articleSize)) {
//            $this->article_sizes->removeElement($articleSize);
//        }
//
//        return $this;
//    }
}
