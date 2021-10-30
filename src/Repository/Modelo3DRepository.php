<?php

namespace App\Repository;

use App\Entity\Modelo3D;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Modelo3D|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modelo3D|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modelo3D[]    findAll()
 * @method Modelo3D[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Modelo3DRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modelo3D::class);
    }

    // /**
    //  * @return Modelo3D[] Returns an array of Modelo3D objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Modelo3D
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
