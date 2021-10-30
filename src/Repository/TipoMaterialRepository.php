<?php

namespace App\Repository;

use App\Entity\TipoMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoMaterial|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoMaterial|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoMaterial[]    findAll()
 * @method TipoMaterial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoMaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoMaterial::class);
    }

    // /**
    //  * @return TipoMaterial[] Returns an array of TipoMaterial objects
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
    public function findOneBySomeField($value): ?TipoMaterial
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
