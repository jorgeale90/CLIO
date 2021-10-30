<?php

namespace App\Repository;

use App\Entity\Planimetria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Planimetria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planimetria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planimetria[]    findAll()
 * @method Planimetria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanimetriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planimetria::class);
    }

    // /**
    //  * @return Planimetria[] Returns an array of Planimetria objects
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
    public function findOneBySomeField($value): ?Planimetria
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
