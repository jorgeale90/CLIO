<?php

namespace App\Repository;

use App\Entity\GeoSistema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GeoSistema|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeoSistema|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeoSistema[]    findAll()
 * @method GeoSistema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeoSistemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeoSistema::class);
    }

    // /**
    //  * @return GeoSistema[] Returns an array of GeoSistema objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeoSistema
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
