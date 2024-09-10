<?php

namespace App\Repository;

use App\Entity\ArrivalSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArrivalSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArrivalSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrivalSetting[]    findAll()
 * @method ArrivalSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArrivalSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArrivalSetting::class);
    }

    // /**
    //  * @return ArrivalSetting[] Returns an array of ArrivalSetting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArrivalSetting
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
