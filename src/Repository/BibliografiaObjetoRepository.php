<?php

namespace App\Repository;

use App\Entity\BibliografiaObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BibliografiaObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method BibliografiaObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method BibliografiaObjeto[]    findAll()
 * @method BibliografiaObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BibliografiaObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BibliografiaObjeto::class);
    }

    // /**
    //  * @return BibliografiaObjeto[] Returns an array of BibliografiaObjeto objects
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
    public function findOneBySomeField($value): ?BibliografiaObjeto
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
