<?php

namespace App\Repository;

use App\Entity\Bibliografia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bibliografia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bibliografia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bibliografia[]    findAll()
 * @method Bibliografia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BibliografiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bibliografia::class);
    }

    // /**
    //  * @return Bibliografia[] Returns an array of Bibliografia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bibliografia
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
