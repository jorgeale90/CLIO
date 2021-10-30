<?php

namespace App\Repository;

use App\Entity\TecnicaAplicada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TecnicaAplicada|null find($id, $lockMode = null, $lockVersion = null)
 * @method TecnicaAplicada|null findOneBy(array $criteria, array $orderBy = null)
 * @method TecnicaAplicada[]    findAll()
 * @method TecnicaAplicada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TecnicaAplicadaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TecnicaAplicada::class);
    }

    // /**
    //  * @return TecnicaAplicada[] Returns an array of TecnicaAplicada objects
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
    public function findOneBySomeField($value): ?TecnicaAplicada
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
