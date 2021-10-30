<?php

namespace App\Controller;

use App\Entity\Integridad;
use App\Form\IntegridadType;
use App\Repository\IntegridadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/integridad")
 */
class IntegridadController extends AbstractController
{
    /**
     * @Route("/", name="integridad_index", methods={"GET"})
     */
    public function index(IntegridadRepository $integridadRepository): Response
    {
        if ($integridadRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Integridades almacenadas en la Base de Datos!!!');
        }

        return $this->render('integridad/index.html.twig', [
            'integridades' => $integridadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="integridad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $integridad = new Integridad();
        $form = $this->createForm(IntegridadType::class, $integridad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($integridad);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Integridad satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Integridad: %s', $integridad->getNombre()));

            return $this->redirectToRoute('integridad_index');
        }

        return $this->render('integridad/new.html.twig', [
            'integridad' => $integridad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="integridad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Integridad $integridad): Response
    {
        $form = $this->createForm(IntegridadType::class, $integridad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Integridad satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Integridad: %s', $integridad->getNombre()));

            return $this->redirectToRoute('integridad_index');
        }

        return $this->render('integridad/edit.html.twig', [
            'integridad' => $integridad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("integridad/remove/{id}", name="removerintegridad")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Integridad::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Integridad!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Integridad satisfactoriamente!!!');
        }

        return $this->redirectToRoute('integridad_index');
    }
}