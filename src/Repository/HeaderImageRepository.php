<?php

namespace App\Repository;

use App\Entity\HeaderImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HeaderImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method HeaderImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method HeaderImage[]    findAll()
 * @method HeaderImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeaderImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeaderImage::class);
    }

    // /**
    //  * @return HeaderImage[] Returns an array of HeaderImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HeaderImage
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
