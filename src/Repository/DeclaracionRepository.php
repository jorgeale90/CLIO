<?php

namespace App\Repository;

use App\Entity\Declaracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Declaracion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Declaracion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Declaracion[]    findAll()
 * @method Declaracion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclaracionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Declaracion::class);
    }

    // /**
    //  * @return Declaracion[] Returns an array of Declaracion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Declaracion
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
