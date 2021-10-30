<?php

namespace App\Repository;

use App\Entity\TratamientoLaboratorio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TratamientoLaboratorio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TratamientoLaboratorio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TratamientoLaboratorio[]    findAll()
 * @method TratamientoLaboratorio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TratamientoLaboratorioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TratamientoLaboratorio::class);
    }

    // /**
    //  * @return TratamientoLaboratorio[] Returns an array of TratamientoLaboratorio objects
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
    public function findOneBySomeField($value): ?TratamientoLaboratorio
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
