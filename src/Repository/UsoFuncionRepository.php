<?php

namespace App\Repository;

use App\Entity\UsoFuncion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsoFuncion|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsoFuncion|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsoFuncion[]    findAll()
 * @method UsoFuncion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsoFuncionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsoFuncion::class);
    }

    // /**
    //  * @return UsoFuncion[] Returns an array of UsoFuncion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsoFuncion
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
