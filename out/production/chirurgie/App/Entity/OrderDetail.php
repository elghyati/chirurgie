<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailRepository::class)
 */
class OrderDetail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $subTotal;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequence;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $relatedOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSubTotal(): ?string
    {
        return $this->subTotal;
    }

    public function setSubTotal(string $subTotal): self
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getRelatedOrder(): ?Order
    {
        return $this->relatedOrder;
    }

    public function setRelatedOrder(?Order $relatedOrder): self
    {
        $this->relatedOrder = $relatedOrder;

        return $this;
    }
}
