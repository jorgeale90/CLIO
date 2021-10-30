<?php

namespace App\Repository;

use App\Entity\CausaIntervencion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CausaIntervencion|null find($id, $lockMode = null, $lockVersion = null)
 * @method CausaIntervencion|null findOneBy(array $criteria, array $orderBy = null)
 * @method CausaIntervencion[]    findAll()
 * @method CausaIntervencion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CausaIntervencionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CausaIntervencion::class);
    }

    // /**
    //  * @return CausaIntervencion[] Returns an array of CausaIntervencion objects
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
    public function findOneBySomeField($value): ?CausaIntervencion
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
