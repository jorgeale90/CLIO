<?php

namespace App\Repository;

use App\Entity\Bibliografias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bibliografias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bibliografias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bibliografias[]    findAll()
 * @method Bibliografias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BibliografiasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bibliografias::class);
    }

    // /**
    //  * @return Bibliografias[] Returns an array of Bibliografias objects
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
    public function findOneBySomeField($value): ?Bibliografias
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
