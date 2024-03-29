<?php

namespace App\Repository;

use App\Entity\ZonaPatrimonialGPS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ZonaPatrimonialGPS|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZonaPatrimonialGPS|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZonaPatrimonialGPS[]    findAll()
 * @method ZonaPatrimonialGPS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZonaPatrimonialGPSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZonaPatrimonialGPS::class);
    }

    // /**
    //  * @return ZonaPatrimonialGPS[] Returns an array of ZonaPatrimonialGPS objects
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
    public function findOneBySomeField($value): ?ZonaPatrimonialGPS
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
