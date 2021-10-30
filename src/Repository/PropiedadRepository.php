<?php

namespace App\Repository;

use App\Entity\Propiedad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Propiedad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Propiedad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Propiedad[]    findAll()
 * @method Propiedad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropiedadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Propiedad::class);
    }

    // /**
    //  * @return Propiedad[] Returns an array of Propiedad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Propiedad
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
