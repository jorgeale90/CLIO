<?php

namespace App\Controller;

use App\Entity\Propiedad;
use App\Form\PropiedadType;
use App\Repository\PropiedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/propiedad")
 */
class PropiedadController extends AbstractController
{
    /**
     * @Route("/", name="propiedad_index", methods={"GET"})
     */
    public function index(PropiedadRepository $propiedadRepository): Response
    {
        if ($propiedadRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Propiedades almacenadas en la Base de Datos!!!');
        }

        return $this->render('propiedad/index.html.twig', [
            'propi' => $propiedadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="propiedad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $propiedad = new Propiedad();
        $form = $this->createForm(PropiedadType::class, $propiedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($propiedad);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Propiedad satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Propiedad: %s', $propiedad->getNombre()));

            return $this->redirectToRoute('propiedad_index');
        }

        return $this->render('propiedad/new.html.twig', [
            'propiedad' => $propiedad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="propiedad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Propiedad $propiedad): Response
    {
        $form = $this->createForm(PropiedadType::class, $propiedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Propiedad satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Propiedad: %s', $propiedad->getNombre()));

            return $this->redirectToRoute('propiedad_index');
        }

        return $this->render('propiedad/edit.html.twig', [
            'propiedad' => $propiedad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("propiedad/remove/{id}", name="removerpropiedad")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Propiedad::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Propiedad!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Propiedad satisfactoriamente!!!');
        }

        return $this->redirectToRoute('propiedad_index');
    }
}