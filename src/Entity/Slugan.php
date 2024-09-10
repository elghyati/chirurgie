<?php

namespace App\Entity;

use App\Repository\SluganRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SluganRepository::class)
 */
class Slugan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $slugan;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlugan(): ?string
    {
        return $this->slugan;
    }

    public function setSlugan(string $slugan): self
    {
        $this->slugan = $slugan;

        return $this;
    }
}
