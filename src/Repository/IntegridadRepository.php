<?php

namespace App\Repository;

use App\Entity\Integridad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Integridad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Integridad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Integridad[]    findAll()
 * @method Integridad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntegridadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Integridad::class);
    }

    // /**
    //  * @return Integridad[] Returns an array of Integridad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Integridad
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
