<?php

namespace App\Repository;

use App\Entity\CoordenadasGPS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoordenadasGPS|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoordenadasGPS|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoordenadasGPS[]    findAll()
 * @method CoordenadasGPS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoordenadasGPSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoordenadasGPS::class);
    }

    // /**
    //  * @return CoordenadasGPS[] Returns an array of CoordenadasGPS objects
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
    public function findOneBySomeField($value): ?CoordenadasGPS
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
