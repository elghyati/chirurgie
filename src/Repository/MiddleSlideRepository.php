<?php

namespace App\Repository;
use App\Entity\MiddleSlide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MiddleSlide|null find($id, $lockMode = null, $lockVersion = null)
 * @method MiddleSlide|null findOneBy(array $criteria, array $orderBy = null)
 * @method MiddleSlide[]    findAll()
 * @method MiddleSlide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MiddleSlideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MiddleSlide::class);
    }

    // /**
    //  * @return MiddleSlide[] Returns an array of MiddleSlide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MiddleSlide
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
