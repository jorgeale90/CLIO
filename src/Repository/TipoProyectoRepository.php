<?php

namespace App\Repository;

use App\Entity\TipoProyecto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoProyecto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoProyecto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoProyecto[]    findAll()
 * @method TipoProyecto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoProyectoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoProyecto::class);
    }

    // /**
    //  * @return TipoProyecto[] Returns an array of TipoProyecto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoProyecto
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
