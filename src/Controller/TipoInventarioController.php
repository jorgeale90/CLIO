<?php

namespace App\Controller;

use App\Entity\TipoInventario;
use App\Form\TipoInventarioType;
use App\Repository\TipoInventarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipoinventario")
 */
class TipoInventarioController extends AbstractController
{
    /**
     * @Route("/", name="tipoinventario_index", methods={"GET","POST"})
     */
    public function index(TipoInventarioRepository $tipoInventarioRepository, Request $request): Response
    {
        if ($tipoInventarioRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Inventarios almacenados en la Base de Datos!!!');
        }

        $entity = new TipoInventario();
        $form = $this->createForm(TipoInventarioType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Inventario satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Inventario: %s', $entity->getNombre()));

            return $this->redirectToRoute('tipoinventario_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('tipoinventario/index.html.twig', [
            'tipos' => $tipoInventarioRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="tipoinventario_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoInventario();
        $form = $this->createForm(TipoInventarioType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Inventario satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Inventario: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipoinventario_index');
        }

        return $this->render('tipoinventario/new.html.twig', [
            'tipo' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipoinventario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoInventario $tipoInventario): Response
    {
        $form = $this->createForm(TipoInventarioType::class, $tipoInventario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Inventario satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Inventario: %s', $tipoInventario->getNombre()));

            return $this->redirectToRoute('tipoinventario_index');
        }

        return $this->render('tipoinventario/edit.html.twig', [
            'tipo' => $tipoInventario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tipoinventario-delete", name="tipoinventario_delete", methods={"POST"})
     */
    public function tipoinventarioDelete(TipoInventarioRepository $tipoInventarioRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $tipoInventarioRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Tipo de Inventario satisfactoriamente!!!');

        return $this->redirectToRoute('tipoinventario_index');
    }
}