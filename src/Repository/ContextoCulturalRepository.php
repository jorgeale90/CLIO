<?php

namespace App\Repository;

use App\Entity\ContextoCultural;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContextoCultural|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContextoCultural|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContextoCultural[]    findAll()
 * @method ContextoCultural[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContextoCulturalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContextoCultural::class);
    }

    // /**
    //  * @return ContextoCultural[] Returns an array of ContextoCultural objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContextoCultural
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
