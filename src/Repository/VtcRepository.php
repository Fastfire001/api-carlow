<?php

namespace App\Repository;

use App\Entity\Vtc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vtc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vtc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vtc[]    findAll()
 * @method Vtc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VtcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vtc::class);
    }

    // /**
    //  * @return Vtc[] Returns an array of Vtc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vtc
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
