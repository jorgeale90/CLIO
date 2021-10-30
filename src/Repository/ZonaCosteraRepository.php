<?php

namespace App\Repository;

use App\Entity\ZonaCostera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ZonaCostera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZonaCostera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZonaCostera[]    findAll()
 * @method ZonaCostera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZonaCosteraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZonaCostera::class);
    }

    // /**
    //  * @return ZonaCostera[] Returns an array of ZonaCostera objects
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
    public function findOneBySomeField($value): ?ZonaCostera
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
