<?php

namespace App\Repository;

use App\Entity\Proyeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Proyeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proyeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proyeto[]    findAll()
 * @method Proyeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProyetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proyeto::class);
    }

    // /**
    //  * @return Proyeto[] Returns an array of Proyeto objects
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
    public function findOneBySomeField($value): ?Proyeto
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
