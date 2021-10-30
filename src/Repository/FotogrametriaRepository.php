<?php

namespace App\Repository;

use App\Entity\Fotogrametria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fotogrametria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fotogrametria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fotogrametria[]    findAll()
 * @method Fotogrametria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FotogrametriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fotogrametria::class);
    }

    // /**
    //  * @return Fotogrametria[] Returns an array of Fotogrametria objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fotogrametria
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
