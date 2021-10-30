<?php

namespace App\Repository;

use App\Entity\TipoSitioNatural;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoSitioNatural|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoSitioNatural|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoSitioNatural[]    findAll()
 * @method TipoSitioNatural[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoSitioNaturalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoSitioNatural::class);
    }

    // /**
    //  * @return TipoSitioNatural[] Returns an array of TipoSitioNatural objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoSitioNatural
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
