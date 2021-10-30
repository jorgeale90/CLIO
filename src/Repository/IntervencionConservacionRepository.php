<?php

namespace App\Repository;

use App\Entity\IntervencionConservacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IntervencionConservacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntervencionConservacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntervencionConservacion[]    findAll()
 * @method IntervencionConservacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntervencionConservacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IntervencionConservacion::class);
    }

    // /**
    //  * @return IntervencionConservacion[] Returns an array of IntervencionConservacion objects
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
    public function findOneBySomeField($value): ?IntervencionConservacion
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
