<?php

namespace App\Repository;

use App\Entity\TipoIntervencionObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoIntervencionObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoIntervencionObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoIntervencionObjeto[]    findAll()
 * @method TipoIntervencionObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoIntervencionObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoIntervencionObjeto::class);
    }

    // /**
    //  * @return TipoIntervencionObjeto[] Returns an array of TipoIntervencionObjeto objects
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
    public function findOneBySomeField($value): ?TipoIntervencionObjeto
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
