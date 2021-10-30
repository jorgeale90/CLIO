<?php

namespace App\Repository;

use App\Entity\PortadaObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PortadaObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortadaObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortadaObjeto[]    findAll()
 * @method PortadaObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortadaObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortadaObjeto::class);
    }

    // /**
    //  * @return PortadaObjeto[] Returns an array of PortadaObjeto objects
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
    public function findOneBySomeField($value): ?PortadaObjeto
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
