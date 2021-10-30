<?php

namespace App\Repository;

use App\Entity\Fotografia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fotografia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fotografia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fotografia[]    findAll()
 * @method Fotografia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FotografiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fotografia::class);
    }

    // /**
    //  * @return Fotografia[] Returns an array of Fotografia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fotografia
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
