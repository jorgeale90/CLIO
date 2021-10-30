<?php

namespace App\Repository;

use App\Entity\CoordenadasUTM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoordenadasUTM|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoordenadasUTM|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoordenadasUTM[]    findAll()
 * @method CoordenadasUTM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoordenadasUTMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoordenadasUTM::class);
    }

    // /**
    //  * @return CoordenadasUTM[] Returns an array of CoordenadasUTM objects
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
    public function findOneBySomeField($value): ?CoordenadasUTM
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
