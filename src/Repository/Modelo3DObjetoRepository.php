<?php

namespace App\Repository;

use App\Entity\Modelo3DObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Modelo3DObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modelo3DObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modelo3DObjeto[]    findAll()
 * @method Modelo3DObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Modelo3DObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modelo3DObjeto::class);
    }

    // /**
    //  * @return Modelo3DObjeto[] Returns an array of Modelo3DObjeto objects
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
    public function findOneBySomeField($value): ?Modelo3DObjeto
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
