<?php

namespace App\Repository;

use App\Entity\SitioPatrimonial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SitioPatrimonial|null find($id, $lockMode = null, $lockVersion = null)
 * @method SitioPatrimonial|null findOneBy(array $criteria, array $orderBy = null)
 * @method SitioPatrimonial[]    findAll()
 * @method SitioPatrimonial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitioPatrimonialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SitioPatrimonial::class);
    }

    public function findAllTypesQuantityBySitio() {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT te, e FROM App:TipoSitio te LEFT JOIN te.sitiopatrimonial e ORDER BY te.nombre ASC');
        return $query->getResult();
    }

    public function findAllSitiosDataArray($searchParam = '')
    {
        $em = $this->getEntityManager();
        $sitios = $em->createQuery(
            "SELECT sp, c, ts, tsc, fot, co, zigps
                  FROM App:SitioPatrimonial sp 
                  INNER JOIN sp.categoria c
                  INNER JOIN sp.tipositio ts
                  INNER JOIN sp.tipositionatural tsc
                  inner JOIN sp.coordenadasgps co
                  INNER JOIN sp.fotografias fot
                  LEFT JOIN sp.zonainsertidumbregps zigps
                  WHERE sp.state = 1 and sp.new = 0 AND sp.nombre LIKE :param"
        );
        $sitios->setParameter('param', '%'.$searchParam.'%');
        return $sitios->getArrayResult();
    }

    public function findSitioObjeto($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT s, s.codigo, s.nombre, o.nombreobjeto, o.autor FROM App:SitioPatrimonial s INNER JOIN s.fichaobjetopatrimonial o WHERE s.id = :id');
        $query->setParameter('id', $id);
        return $query->getArrayResult();
    }

    // /**
    //  * @return SitioPatrimonial[] Returns an array of SitioPatrimonial objects
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
    public function findOneBySomeField($value): ?SitioPatrimonial
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
