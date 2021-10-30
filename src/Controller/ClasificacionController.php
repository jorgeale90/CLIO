<?php

namespace App\Controller;

use App\Entity\Clasificacion;
use App\Form\ClasificacionType;
use App\Repository\ClasificacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/clasificacion")
 */
class ClasificacionController extends AbstractController
{
    /**
     * @Route("/", name="clasificacion_index", methods={"GET"})
     */
    public function index(ClasificacionRepository $clasificacionRepository): Response
    {
        if ($clasificacionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Clasificaciones almacenadas en la Base de Datos!!!');
        }

        return $this->render('clasificacion/index.html.twig', [
            'clasificacion' => $clasificacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="clasificacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $clasificacion = new Clasificacion();
        $form = $this->createForm(ClasificacionType::class, $clasificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clasificacion);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Clasificación satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Clasificación: %s', $clasificacion->getNombre()));

            return $this->redirectToRoute('clasificacion_index');
        }

        return $this->render('clasificacion/new.html.twig', [
            'clasificacion' => $clasificacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="clasificacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Clasificacion $clasificacion): Response
    {
        $form = $this->createForm(ClasificacionType::class, $clasificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Clasificación satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Clasificación: %s', $clasificacion->getNombre()));

            return $this->redirectToRoute('clasificacion_index');
        }

        return $this->render('clasificacion/edit.html.twig', [
            'clasificacion' => $clasificacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("clasificacion/remove/{id}", name="removerclasificacion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Clasificacion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Clasificación!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Clasificación satisfactoriamente!!!');
        }

        return $this->redirectToRoute('clasificacion_index');
    }
}