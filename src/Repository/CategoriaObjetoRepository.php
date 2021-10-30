<?php

namespace App\Repository;

use App\Entity\CategoriaObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriaObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaObjeto[]    findAll()
 * @method CategoriaObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaObjeto::class);
    }

    // /**
    //  * @return CategoriaObjeto[] Returns an array of CategoriaObjeto objects
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
    public function findOneBySomeField($value): ?CategoriaObjeto
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
