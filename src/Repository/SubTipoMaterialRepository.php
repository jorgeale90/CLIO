<?php

namespace App\Repository;

use App\Entity\SubTipoMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubTipoMaterial|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubTipoMaterial|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubTipoMaterial[]    findAll()
 * @method SubTipoMaterial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubTipoMaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubTipoMaterial::class);
    }

    // /**
    //  * @return SubTipoMaterial[] Returns an array of SubTipoMaterial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubTipoMaterial
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
