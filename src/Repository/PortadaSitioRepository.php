<?php

namespace App\Repository;

use App\Entity\PortadaSitio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PortadaSitio|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortadaSitio|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortadaSitio[]    findAll()
 * @method PortadaSitio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortadaSitioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortadaSitio::class);
    }

    // /**
    //  * @return PortadaSitio[] Returns an array of PortadaSitio objects
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
    public function findOneBySomeField($value): ?PortadaSitio
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
