<?php

namespace App\Repository;

use App\Entity\PromotionSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PromotionSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromotionSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromotionSetting[]    findAll()
 * @method PromotionSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromotionSetting::class);
    }

    // /**
    //  * @return PromotionSetting[] Returns an array of PromotionSetting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PromotionSetting
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
