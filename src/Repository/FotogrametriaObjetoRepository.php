<?php

namespace App\Repository;

use App\Entity\FotogrametriaObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FotogrametriaObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method FotogrametriaObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method FotogrametriaObjeto[]    findAll()
 * @method FotogrametriaObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FotogrametriaObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FotogrametriaObjeto::class);
    }

    // /**
    //  * @return FotogrametriaObjeto[] Returns an array of FotogrametriaObjeto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FotogrametriaObjeto
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
