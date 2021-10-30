<?php

namespace App\Repository;

use App\Entity\Contexto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contexto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contexto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contexto[]    findAll()
 * @method Contexto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContextoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contexto::class);
    }

    // /**
    //  * @return Contexto[] Returns an array of Contexto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contexto
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
