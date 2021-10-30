<?php

namespace App\Repository;

use App\Entity\ZonaObjetoGPS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ZonaObjetoGPS|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZonaObjetoGPS|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZonaObjetoGPS[]    findAll()
 * @method ZonaObjetoGPS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZonaObjetoGPSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZonaObjetoGPS::class);
    }

    // /**
    //  * @return ZonaObjetoGPS[] Returns an array of ZonaObjetoGPS objects
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
    public function findOneBySomeField($value): ?ZonaObjetoGPS
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
