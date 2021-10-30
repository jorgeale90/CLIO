<?php

namespace App\Controller;

use App\Entity\Profesion;
use App\Form\ProfesionType;
use App\Repository\ProfesionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/profesion")
 */
class ProfesionController extends AbstractController
{
    /**
     * @Route("/", name="profesion_index", methods={"GET","POST"})
     */
    public function index(ProfesionRepository $profesionRepository, Request $request): Response
    {
        if ($profesionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Profesiones almacenados en la Base de Datos!!!');
        }

        $entity = new Profesion();
        $form = $this->createForm(ProfesionType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Profesión satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Profesión: %s', $entity->getNombre()));

            return $this->redirectToRoute('profesion_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('profesion/index.html.twig', [
            'profeciones' => $profesionRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="profesion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profesion = new Profesion();
        $form = $this->createForm(ProfesionType::class, $profesion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profesion);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Profesión satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Profesión: %s', $profesion->getNombre()));

            return $this->redirectToRoute('profesion_index');
        }

        return $this->render('profesion/new.html.twig', [
            'profesion' => $profesion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="profesion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Profesion $profesion): Response
    {
        $form = $this->createForm(ProfesionType::class, $profesion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Profesión satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Profesión: %s', $profesion->getNombre()));

            return $this->redirectToRoute('profesion_index');
        }

        return $this->render('profesion/edit.html.twig', [
            'profesion' => $profesion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profesion-delete", name="profesion_delete", methods={"POST"})
     */
    public function profesionDelete(ProfesionRepository $profesionRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $profesionRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado una Profesión satisfactoriamente!!!');

        return $this->redirectToRoute('profesion_index');
    }
}