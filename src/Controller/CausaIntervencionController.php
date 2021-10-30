<?php

namespace App\Controller;

use App\Entity\CausaIntervencion;
use App\Form\CausaIntervencionType;
use App\Repository\CausaIntervencionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Tests\CustomApplication;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/causaintervencion")
 */
class CausaIntervencionController extends AbstractController
{
    /**
     * @Route("/", name="causaintervencion_index", methods={"GET"})
     */
    public function index(CausaIntervencionRepository $causaIntervencionRepository): Response
    {
        if ($causaIntervencionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Causas de Intervenciones almacenados en la Base de Datos!!!');
        }

        return $this->render('causaintervencion/index.html.twig', [
            'causasint' => $causaIntervencionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="causaintervencion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $causainterv = new CausaIntervencion();
        $form = $this->createForm(CausaIntervencionType::class, $causainterv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($causainterv);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Causa de Intervención satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Causa de Intervención: %s', $causainterv->getNombre()));

            return $this->redirectToRoute('causaintervencion_index');
        }

        return $this->render('causaintervencion/new.html.twig', [
            'causaint' => $causainterv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="causaintervencion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CausaIntervencion $causaIntervencion): Response
    {
        $form = $this->createForm(CausaIntervencionType::class, $causaIntervencion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Causa de Intervención satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Causa de Intervención: %s', $causaIntervencion->getNombre()));

            return $this->redirectToRoute('causaintervencion_index');
        }

        return $this->render('causaintervencion/edit.html.twig', [
            'causainter' => $causaIntervencion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("causaintervencion/remove/{id}", name="removercausaintervencion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(CausaIntervencion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Causa de Intervención!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Causa de Intervención satisfactoriamente!!!');
        }

        return $this->redirectToRoute('causaintervencion_index');
    }
}