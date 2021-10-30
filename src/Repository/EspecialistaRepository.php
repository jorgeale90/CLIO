<?php

namespace App\Repository;

use App\Entity\Especialista;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Especialista|null find($id, $lockMode = null, $lockVersion = null)
 * @method Especialista|null findOneBy(array $criteria, array $orderBy = null)
 * @method Especialista[]    findAll()
 * @method Especialista[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspecialistaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Especialista::class);
    }

    public function findAllTypesQuantityByInvestigador() {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT te, e FROM App:TipoEspecialista te LEFT JOIN te.especialistas e ORDER BY te.nombre ASC');
        return $query->getResult();
    }

//    public function findEspecialistaByProyecto($id)
//    {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('SELECT e, p.nombre, p.codProyecto, p.fechaInicio, p.fechaFin FROM App:Especialista e INNER JOIN e.proyectos p WHERE e.id = :id');
//        $query->setParameter('id', $id);
//        return $query->getArrayResult();
//    }

//    public function findEspecialistaByProyectoJefe($id)
//    {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('SELECT e, p.nombre, p.codProyecto, p.fechaInicio, p.fechaFin FROM App:Especialista e INNER JOIN e.proyectosParticipantes p WHERE e.id = :id');
//        $query->setParameter('id', $id);
//        return $query->getArrayResult();
//    }

//    public function findAllTiposEspecialistas() {
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('SELECT te, e FROM App:TipoEspecialista te LEFT JOIN te.especialistas e ORDER BY te.nombretipoesp ASC');
//        return $query->getResult();
//    }

    // /**
    //  * @return Especialista[] Returns an array of Especialista objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Especialista
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
