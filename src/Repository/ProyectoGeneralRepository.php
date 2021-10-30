<?php

namespace App\Repository;

use App\Entity\ProyectoGeneral;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProyectoGeneral|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProyectoGeneral|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProyectoGeneral[]    findAll()
 * @method ProyectoGeneral[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProyectoGeneralRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProyectoGeneral::class);
    }

    // /**
    //  * @return ProyectoGeneral[] Returns an array of ProyectoGeneral objects
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
    public function findOneBySomeField($value): ?ProyectoGeneral
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
