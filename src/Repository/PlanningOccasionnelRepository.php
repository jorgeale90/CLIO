<?php

namespace App\Repository;

use App\Entity\PlanningOccasionnel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlanningOccasionnel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningOccasionnel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningOccasionnel[]    findAll()
 * @method PlanningOccasionnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningOccasionnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanningOccasionnel::class);
    }

    // /**
    //  * @return PlanningOccasionnel[] Returns an array of PlanningOccasionnel objects
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
    public function findOneBySomeField($value): ?PlanningOccasionnel
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
