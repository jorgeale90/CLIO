<?php

namespace App\Repository;

use App\Entity\TipoSitio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoSitio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoSitio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoSitio[]    findAll()
 * @method TipoSitio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoSitioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoSitio::class);
    }

    // /**
    //  * @return TipoSitio[] Returns an array of TipoSitio objects
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
    public function findOneBySomeField($value): ?TipoSitio
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
