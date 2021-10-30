<?php

namespace App\Repository;

use App\Entity\CartaAutorizacionInventario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CartaAutorizacionInventario|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartaAutorizacionInventario|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartaAutorizacionInventario[]    findAll()
 * @method CartaAutorizacionInventario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartaAutorizacionInventarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartaAutorizacionInventario::class);
    }

    // /**
    //  * @return CartaAutorizacionInventario[] Returns an array of CartaAutorizacionInventario objects
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
    public function findOneBySomeField($value): ?CartaAutorizacionInventario
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
