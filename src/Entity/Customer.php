<?php

namespace App\Entity;

use App\Entity\Comment;
use App\Entity\Order;
use App\Entity\User;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer extends User {


}
