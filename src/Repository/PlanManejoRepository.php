<?php

namespace App\Repository;

use App\Entity\PlanManejo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlanManejo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanManejo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanManejo[]    findAll()
 * @method PlanManejo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanManejoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanManejo::class);
    }

    // /**
    //  * @return PlanManejo[] Returns an array of PlanManejo objects
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
    public function findOneBySomeField($value): ?PlanManejo
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
