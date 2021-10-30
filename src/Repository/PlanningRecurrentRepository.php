<?php

namespace App\Repository;

use App\Entity\PlanningRecurrent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlanningRecurrent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningRecurrent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningRecurrent[]    findAll()
 * @method PlanningRecurrent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningRecurrentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanningRecurrent::class);
    }

    // /**
    //  * @return PlanningRecurrent[] Returns an array of PlanningRecurrent objects
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
    public function findOneBySomeField($value): ?PlanningRecurrent
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
