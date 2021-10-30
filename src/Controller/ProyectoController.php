<?php

namespace App\Controller;

use App\Entity\Proyecto;
use App\Form\ProyectoType;
use App\Repository\ProyectoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/proyecto")
 */
class ProyectoController extends AbstractController
{
    /**
     * @Route("/", name="proyecto_index", methods={"GET"})
     */
    public function index(ProyectoRepository $proyectoRepository): Response
    {
        if ($proyectoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Proyectos almacenados en la Base de Datos!!!');
        }

        return $this->render('proyecto/index.html.twig', [
            'proyectos' => $proyectoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="proyectolist_index", methods={"GET"})
     */
    public function listproyecto(ProyectoRepository $proyectoRepository): Response
    {
        return $this->render('proyecto/index.html.twig', [
            'proyectos' => $proyectoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="proyecto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $proyecto = new Proyecto();
        $form = $this->createForm(ProyectoType::class, $proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proyecto);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Proyecto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Proyecto: %s', $proyecto->getNombre()));

            return $this->redirectToRoute('proyecto_index');
        }

        return $this->render('proyecto/new.html.twig', [
            'proyecto' => $proyecto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="proyecto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Proyecto $proyecto): Response
    {
        $form = $this->createForm(ProyectoType::class, $proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado el Proyecto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Proyecto: %s', $proyecto->getNombre()));

            return $this->redirectToRoute('proyecto_index');
        }

        return $this->render('proyecto/edit.html.twig', [
            'proyecto' => $proyecto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="proyecto_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('App:Proyecto')->find($id);

        $form = $this->createForm(ProyectoType::class, $entities);

        return $this->render('proyecto/show.html.twig', array(
            'entities'      => $entities,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/proyectoesp", name="proyectoesp_show", methods={"GET"})
     */
    public function proyectoesp($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('App:Proyecto')->find($id);

        $form = $this->createForm(ProyectoType::class, $entities);

        return $this->render('proyecto/mostrar.html.twig', array(
            'entities'      => $entities,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("proyecto/remove/{id}", name="removerproyecto")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Proyecto::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Proyecto!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Proyecto satisfactoriamente!!!');
        }

        return $this->redirectToRoute('proyecto_index');
    }
}
