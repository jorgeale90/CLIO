<?php

namespace App\Repository;

use App\Entity\PublicacionesObjeto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublicacionesObjeto|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicacionesObjeto|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicacionesObjeto[]    findAll()
 * @method PublicacionesObjeto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicacionesObjetoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicacionesObjeto::class);
    }

    // /**
    //  * @return PublicacionesObjeto[] Returns an array of PublicacionesObjeto objects
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
    public function findOneBySomeField($value): ?PublicacionesObjeto
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
