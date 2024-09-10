<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SizeRepository::class)
 */
class Size {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $size;

//    /**
//     * @ORM\OneToMany(targetEntity=ArticleSize::class, mappedBy="size")
//     */
//    private $articles;

    public function __construct() {
//        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getSize(): ?string {
        return $this->size;
    }

    public function setSize(string $size): self {
        $this->size = $size;
        return $this;
    }

    public function __toString(): ?string {
        return $this->size;
    }

//    /**
//     * @return Collection|ArticleSize[]
//     */
//    public function getArticles(): Collection
//    {
//        return $this->articles;
//    }
//
//    public function addArticle(ArticleSize $article): self
//    {
//        if (!$this->articles->contains($article)) {
//            $this->articles[] = $article;
//            $article->setSize($this);
//        }
//
//        return $this;
//    }
//
//    public function removeArticle(ArticleSize $article): self
//    {
//        if ($this->articles->contains($article)) {
//            $this->articles->removeElement($article);
//            // set the owning side to null (unless already changed)
//            if ($article->getSize() === $this) {
//                $article->setSize(null);
//            }
//        }
//
//        return $this;
//    }
}
