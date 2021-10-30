<?php

namespace App\Repository;

use App\Entity\TratamientoInsitu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TratamientoInsitu|null find($id, $lockMode = null, $lockVersion = null)
 * @method TratamientoInsitu|null findOneBy(array $criteria, array $orderBy = null)
 * @method TratamientoInsitu[]    findAll()
 * @method TratamientoInsitu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TratamientoInsituRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TratamientoInsitu::class);
    }

    // /**
    //  * @return TratamientoInsitu[] Returns an array of TratamientoInsitu objects
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
    public function findOneBySomeField($value): ?TratamientoInsitu
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
