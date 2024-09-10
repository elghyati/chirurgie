<?php

namespace App\Twig;

use App\Entity\Slugan;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CatsExtension extends AbstractExtension
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getSlugan', [$this, 'getSlugan'])
        ];
    }

    public function getSlugan()
    {
        return $this->em->getRepository(Slugan::class)->findAll();
    }
}