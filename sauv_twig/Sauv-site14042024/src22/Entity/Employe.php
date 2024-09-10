<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=EmployeRepository::class)
 */
class Employe extends User {

//    /**
//     * @ORM\Id()
//     * @ORM\GeneratedValue()
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    public function getId(): ?int {
//        return $this->id;
//    }

}
