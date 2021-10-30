<?php

namespace App\Repository;

use App\Entity\ReferenciaWebObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReferenciaWebObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenciaWebObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenciaWebObjeto[]    findAll()
 * @method ReferenciaWebObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenciaWebObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferenciaWebObjeto::class);
    }

    // /**
    //  * @return ReferenciaWebObjeto[] Returns an array of ReferenciaWebObjeto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReferenciaWebObjeto
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
