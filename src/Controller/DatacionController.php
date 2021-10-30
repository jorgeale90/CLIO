<?php

namespace App\Controller;

use App\Entity\Datacion;
use App\Form\DatacionType;
use App\Repository\DatacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/datacion")
 */
class DatacionController extends AbstractController
{
    /**
     * @Route("/", name="datacion_index", methods={"GET"})
     */
    public function index(DatacionRepository $datacionRepository): Response
    {
        if ($datacionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Dataciones almacenadas en la Base de Datos!!!');
        }

        return $this->render('datacion/index.html.twig', [
            'data' => $datacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="datacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $data = new Datacion();
        $form = $this->createForm(DatacionType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Datación satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Datación: %s', $data->getNombre()));

            return $this->redirectToRoute('datacion_index');
        }

        return $this->render('datacion/new.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="datacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Datacion $datacion): Response
    {
        $form = $this->createForm(DatacionType::class, $datacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Datación satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Datación: %s', $datacion->getNombre()));

            return $this->redirectToRoute('datacion_index');
        }

        return $this->render('datacion/edit.html.twig', [
            'data' => $datacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("datacion/remove/{id}", name="removerdatacion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Datacion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Datación!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Datación satisfactoriamente!!!');
        }

        return $this->redirectToRoute('datacion_index');
    }
}