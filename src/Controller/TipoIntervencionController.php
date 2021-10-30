<?php

namespace App\Controller;

use App\Entity\Intervencion;
use App\Entity\TipoIntervencion;
use App\Form\TipoIntervencionType;
use App\Repository\TipoIntervencionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipointervencion")
 */
class TipoIntervencionController extends AbstractController
{
    /**
     * @Route("/", name="tipointervencion_index", methods={"GET"})
     */
    public function index(TipoIntervencionRepository $tipoIntervencionRepository): Response
    {
        if ($tipoIntervencionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Intervenciones almacenados en la Base de Datos!!!');
        }

        return $this->render('tipointervencion/index.html.twig', [
            'tipointerv' => $tipoIntervencionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipointervencion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoIntervencion();
        $form = $this->createForm(TipoIntervencionType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Intervención satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Intervención: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipointervencion_index');
        }

        return $this->render('tipointervencion/new.html.twig', [
            'tipoin' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipointervencion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoIntervencion $tipoIntervencion): Response
    {
        $form = $this->createForm(TipoIntervencionType::class, $tipoIntervencion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Intervención satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Intervención: %s', $tipoIntervencion->getNombre()));

            return $this->redirectToRoute('tipointervencion_index');
        }

        return $this->render('tipointervencion/edit.html.twig', [
            'tipointer' => $tipoIntervencion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("tipointervencion/remove/{id}", name="removertipointervencion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TipoIntervencion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Tipo de Intervención!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Tipo de Intervención satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tipointervencion_index');
    }
}