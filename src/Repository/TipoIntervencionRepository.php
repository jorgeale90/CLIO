<?php

namespace App\Repository;

use App\Entity\TipoIntervencion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoIntervencion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoIntervencion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoIntervencion[]    findAll()
 * @method TipoIntervencion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoIntervencionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoIntervencion::class);
    }

    // /**
    //  * @return TipoIntervencion[] Returns an array of TipoIntervencion objects
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
    public function findOneBySomeField($value): ?TipoIntervencion
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
