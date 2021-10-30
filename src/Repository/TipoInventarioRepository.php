<?php

namespace App\Repository;

use App\Entity\TipoInventario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoInventario|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoInventario|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoInventario[]    findAll()
 * @method TipoInventario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoInventarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoInventario::class);
    }

    // /**
    //  * @return TipoInventario[] Returns an array of TipoInventario objects
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
    public function findOneBySomeField($value): ?TipoInventario
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
