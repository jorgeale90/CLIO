<?php

namespace App\Repository;

use App\Entity\Clasificacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clasificacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clasificacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clasificacion[]    findAll()
 * @method Clasificacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasificacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clasificacion::class);
    }

    // /**
    //  * @return Clasificacion[] Returns an array of Clasificacion objects
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
    public function findOneBySomeField($value): ?Clasificacion
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
