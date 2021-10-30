<?php

namespace App\Controller;

use App\Entity\NivelEscolar;
use App\Form\NivelEscolarType;
use App\Repository\NivelEscolarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/nivelescolar")
 */
class NivelEscolarController extends AbstractController
{

    /**
     * @Route("/", name="nivelescolar_index", methods={"GET","POST"})
     */
    public function index(NivelEscolarRepository $nivelEscolarRepository, Request $request): Response
    {
        if ($nivelEscolarRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Niveles Escolares almacenados en la Base de Datos!!!');
        }

        $entity = new NivelEscolar();
        $form = $this->createForm(NivelEscolarType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Nivel Escolar satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Nivel Escolar: %s', $entity->getNombre()));

            return $this->redirectToRoute('nivelescolar_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('nivelescolar/index.html.twig', [
            'niveles' => $nivelEscolarRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="nivelescolar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $nivel = new NivelEscolar();
        $form = $this->createForm(NivelEscolarType::class, $nivel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nivel);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Nivel Escolar satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Nivel Escolar: %s', $nivel->getNombre()));

            return $this->redirectToRoute('nivelescolar_index');
        }

        return $this->render('nivelescolar/new.html.twig', [
            'nivel' => $nivel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nivelescolar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NivelEscolar $nivelEscolar): Response
    {
        $form = $this->createForm(NivelEscolarType::class, $nivelEscolar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Nivel Escolar satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Nivel Escolar: %s', $nivelEscolar->getNombre()));

            return $this->redirectToRoute('nivelescolar_index');
        }

        return $this->render('nivelescolar/edit.html.twig', [
            'nivelEscolar' => $nivelEscolar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nivelescolar-delete", name="nivelescolar_delete", methods={"POST"})
     */
    public function nivelEscolarDelete(NivelEscolarRepository $nivelEscolarRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $nivelEscolarRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Nivel Escolar satisfactoriamente!!!');

        return $this->redirectToRoute('nivelescolar_index');
    }
}