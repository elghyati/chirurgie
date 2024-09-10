<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $reference;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="relatedOrder",  cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $orderDetails;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $updatedBy;

    /**
     * @ORM\ManyToOne(targetEntity=OrderStatus::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    public function __construct() {
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAmount(): ?string {
        return $this->amount;
    }

    public function setAmount(string $amount): self {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection|OrderDetail[]
     */
    public function getOrderDetails(): Collection {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setRelatedOrder($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self {
        if ($this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->removeElement($orderDetail);
            // set the owning side to null (unless already changed)
            if ($orderDetail->getRelatedOrder() === $this) {
                $orderDetail->setRelatedOrder(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void
     */
    public function initializeUpdatedAt() {
        $this->updatedAt = new \DateTime('now');
    }

    public function getCustomer(): ?Customer {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self {
        $this->customer = $customer;

        return $this;
    }

    public function getUpdatedBy(): ?User {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): self {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getStatus(): ?OrderStatus {
        return $this->status;
    }

    public function setStatus(?OrderStatus $status): self {
        $this->status = $status;

        return $this;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference): void {
        $this->reference = $reference;
    }

}
