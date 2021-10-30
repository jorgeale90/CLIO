<?php

namespace App\Controller;

use App\Entity\TipoProyecto;
use App\Form\TipoProyectoType;
use App\Repository\TipoProyectoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipoproyecto")
 */
class TipoProyectoController extends AbstractController
{
    /**
     * @Route("/", name="tipoproyecto_index", methods={"GET"})
     */
    public function index(TipoProyectoRepository $tipoProyectoRepository): Response
    {
        if ($tipoProyectoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Proyectos almacenados en la Base de Datos!!!');
        }

        return $this->render('tipoproyecto/index.html.twig', [
            'tipos' => $tipoProyectoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipoproyecto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoProyecto();
        $form = $this->createForm(TipoProyectoType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Proyecto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Proyecto: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipoproyecto_index');
        }

        return $this->render('tipoproyecto/new.html.twig', [
            'tipo' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipoproyecto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoProyecto $sitio): Response
    {
        $form = $this->createForm(TipoProyectoType::class, $sitio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Proyecto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Proyecto: %s', $sitio->getNombre()));

            return $this->redirectToRoute('tipoproyecto_index');
        }

        return $this->render('tipoproyecto/edit.html.twig', [
            'sitio' => $sitio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("tipoproyecto/remove/{id}", name="removertipoproyecto")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TipoProyecto::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Tipo de Proyecto!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Tipo de Proyecto satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tipoproyecto_index');
    }
}