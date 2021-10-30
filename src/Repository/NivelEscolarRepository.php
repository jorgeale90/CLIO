<?php

namespace App\Repository;

use App\Entity\NivelEscolar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NivelEscolar|null find($id, $lockMode = null, $lockVersion = null)
 * @method NivelEscolar|null findOneBy(array $criteria, array $orderBy = null)
 * @method NivelEscolar[]    findAll()
 * @method NivelEscolar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NivelEscolarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NivelEscolar::class);
    }

    // /**
    //  * @return NivelEscolar[] Returns an array of NivelEscolar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NivelEscolar
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
