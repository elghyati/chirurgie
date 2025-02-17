<?php

namespace App\Repository;

use App\Entity\Slugan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Slugan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slugan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slugan[]    findAll()
 * @method Slugan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SluganRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slugan::class);
    }

    // /**
    //  * @return Slugan[] Returns an array of Slugan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Slugan
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
