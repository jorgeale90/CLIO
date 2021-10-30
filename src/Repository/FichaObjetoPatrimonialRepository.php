<?php

namespace App\Repository;

use App\Entity\FichaObjetoPatrimonial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FichaObjetoPatrimonial|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaObjetoPatrimonial|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaObjetoPatrimonial[]    findAll()
 * @method FichaObjetoPatrimonial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaObjetoPatrimonialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichaObjetoPatrimonial::class);
    }

    public function findAllTypesQuantityByFicha() {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT tm, e FROM App:TipoMaterial tm LEFT JOIN tm.fichaobjeto e ORDER BY tm.nombre ASC');
        return $query->getResult();
    }

    public function findBySitio($sitiopatrimonial_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:FichaObjetoPatrimonial m WHERE m.sitiopatrimonial = :sitiopatrimonial_id');
        $consulta->setParameter('sitiopatrimonial_id', $sitiopatrimonial_id);
        return $consulta->getArrayResult();
    }

    public function findBySitioInvpre($sitiopatrimonial_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:FichaObjetoPatrimonial m WHERE m.sitiopatrimonial = :sitiopatrimonial_id');
        $consulta->setParameter('sitiopatrimonial_id', $sitiopatrimonial_id);
        return $consulta->getArrayResult();
    }

    public function findBySitioInv($sitiopatrimonial_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:FichaObjetoPatrimonial m WHERE m.sitiopatrimonial = :sitiopatrimonial_id');
        $consulta->setParameter('sitiopatrimonial_id', $sitiopatrimonial_id);
        return $consulta->getArrayResult();
    }

    public function findOjetoIntervenido($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT f, f.nombreobjeto, f.codigoobjeto, i.cod_intervencion, i.fechainicio, i.fechafin FROM App:FichaObjetoPatrimonial f INNER JOIN f.intervencionconservacion i WHERE f.id = :id');
        $query->setParameter('id', $id);
        return $query->getArrayResult();
    }

    // /**
    //  * @return FichaObjetoPatrimonial[] Returns an array of FichaObjetoPatrimonial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FichaObjetoPatrimonial
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
