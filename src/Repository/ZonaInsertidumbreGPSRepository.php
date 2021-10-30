<?php

namespace App\Repository;

use App\Entity\ZonaInsertidumbreGPS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ZonaInsertidumbreGPS|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZonaInsertidumbreGPS|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZonaInsertidumbreGPS[]    findAll()
 * @method ZonaInsertidumbreGPS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZonaInsertidumbreGPSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZonaInsertidumbreGPS::class);
    }

    // /**
    //  * @return ZonaInsertidumbreGPS[] Returns an array of ZonaInsertidumbreGPS objects
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
    public function findOneBySomeField($value): ?ZonaInsertidumbreGPS
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
