<?php

namespace App\Entity;

use App\Repository\OrderStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderStatusRepository::class)
 */
class OrderStatus {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libstatus;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="status")
     */
    private $orders;

    public function __construct() {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLibstatus(): ?string {
        return $this->libstatus;
    }

    public function setLibstatus(string $libstatus): self {
        $this->libstatus = $libstatus;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection {
        return $this->orders;
    }

    public function addOrder(Order $order): self {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setStatus($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getStatus() === $this) {
                $order->setStatus(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->libstatus;
    }

}
