<?php

namespace App\Controller;

use App\Entity\TipoEspecialista;
use App\Form\TipoEspecialistaType;
use App\Repository\TipoEspecialistaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipoespecialista")
 */
class TipoEspecialistaController extends AbstractController
{
    /**
     * @Route("/", name="tipoespecialista_index", methods={"GET","POST"})
     */
    public function index(TipoEspecialistaRepository $tipoEspecialistaRepository, Request $request): Response
    {
        if ($tipoEspecialistaRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Especialistas almacenados en la Base de Datos!!!');
        }

        $entity = new TipoEspecialista();
        $form = $this->createForm(TipoEspecialistaType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Especialista satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Especialista: %s', $entity->getNombre()));

            return $this->redirectToRoute('tipoespecialista_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('tipoespecialista/index.html.twig', [
            'tipos' => $tipoEspecialistaRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="tipoespecialista_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoEspecialista();
        $form = $this->createForm(TipoEspecialistaType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Especialista satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Especialista: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipoespecialista_index');
        }

        return $this->render('tipoespecialista/new.html.twig', [
            'tipo' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipoespecialista_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoEspecialista $tipoEspecialista): Response
    {
        $form = $this->createForm(TipoEspecialistaType::class, $tipoEspecialista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Especialista satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Especialista: %s', $tipoEspecialista->getNombre()));

            return $this->redirectToRoute('tipoespecialista_index');
        }

        return $this->render('tipoespecialista/edit.html.twig', [
            'tipo' => $tipoEspecialista,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tipoespecialista-delete", name="tipoespecialista_delete", methods={"POST"})
     */
    public function tipoespecialistaDelete(TipoEspecialistaRepository $tipoEspecialistaRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $tipoEspecialistaRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Tipo de Especialista satisfactoriamente!!!');

        return $this->redirectToRoute('tipoespecialista_index');
    }
}