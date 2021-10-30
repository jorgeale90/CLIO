<?php

namespace App\Repository;

use App\Entity\OrdenInventario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrdenInventario|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdenInventario|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdenInventario[]    findAll()
 * @method OrdenInventario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdenInventarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdenInventario::class);
    }

    // /**
    //  * @return OrdenInventario[] Returns an array of OrdenInventario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrdenInventario
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
