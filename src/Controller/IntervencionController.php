<?php

namespace App\Controller;

use App\Entity\Intervencion;
use App\Form\IntervencionType;
use App\Repository\IntervencionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/intervencion")
 */
class IntervencionController extends AbstractController
{
    /**
     * @Route("/", name="intervencion_index", methods={"GET"})
     */
    public function index(IntervencionRepository $intervencionRepository): Response
    {
        if ($intervencionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Intervenciones almacenados en la Base de Datos!!!');
        }

        return $this->render('intervencion/index.html.twig', [
            'interv' => $intervencionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="intervencionlist_index", methods={"GET"})
     */
    public function listadoIntervencion(IntervencionRepository $intervencionRepository): Response
    {
        return $this->render('intervencion/index.html.twig', [
            'interv' => $intervencionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="intervencion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $interv = new Intervencion();
        $form = $this->createForm(IntervencionType::class, $interv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($interv);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Intervención satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Intervención: %s', $interv->getCodIntervencion()));

            return $this->redirectToRoute('intervencion_index');
        }

        return $this->render('intervencion/new.html.twig', [
            'interv' => $interv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="intervencion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Intervencion $intervencion): Response
    {
        $form = $this->createForm(IntervencionType::class, $intervencion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Intervención satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Intervención: %s', $intervencion->getCodIntervencion()));

            return $this->redirectToRoute('intervencion_index');
        }

        return $this->render('intervencion/edit.html.twig', [
            'interv' => $intervencion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="intervencion_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('App:Intervencion')->find($id);

        $form = $this->createForm(IntervencionType::class, $entities);

        return $this->render('intervencion/show.html.twig', array(
            'entities'      => $entities,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/intervencionesp", name="intervencionesp_show", methods={"GET"})
     */
    public function intervencionesp($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('App:Intervencion')->find($id);

        $form = $this->createForm(IntervencionType::class, $entities);

        return $this->render('intervencion/mostrar.html.twig', array(
            'entities'      => $entities,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("intervencion/remove/{id}", name="removerintervencion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Intervencion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Intervención!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Intervención satisfactoriamente!!!');
        }

        return $this->redirectToRoute('intervencion_index');
    }
}