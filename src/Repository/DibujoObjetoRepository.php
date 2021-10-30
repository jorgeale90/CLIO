<?php

namespace App\Repository;

use App\Entity\DibujoObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DibujoObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method DibujoObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method DibujoObjeto[]    findAll()
 * @method DibujoObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DibujoObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DibujoObjeto::class);
    }

    // /**
    //  * @return DibujoObjeto[] Returns an array of DibujoObjeto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DibujoObjeto
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
