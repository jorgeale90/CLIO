<?php

namespace App\Repository;

use App\Entity\ZonaProteccionGPS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ZonaProteccionGPS|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZonaProteccionGPS|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZonaProteccionGPS[]    findAll()
 * @method ZonaProteccionGPS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZonaProteccionGPSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZonaProteccionGPS::class);
    }

    // /**
    //  * @return ZonaProteccionGPS[] Returns an array of ZonaProteccionGPS objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ZonaProteccionGPS
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
