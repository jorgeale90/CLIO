<?php

namespace App\Controller;

use App\Entity\TratamientoLaboratorio;
use App\Form\TratamientoLaboratorioType;
use App\Repository\TratamientoLaboratorioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tratamientolaboratorio")
 */
class TratamientoLaboratorioController extends AbstractController
{
    /**
     * @Route("/", name="tratamientolaboratorio_index", methods={"GET","POST"})
     */
    public function index(TratamientoLaboratorioRepository $tratamientoLaboratorioRepository, Request $request): Response
    {
        if ($tratamientoLaboratorioRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tratamiento de Laboratorio almacenados en la Base de Datos!!!');
        }

        $entity = new TratamientoLaboratorio();
        $form = $this->createForm(TratamientoLaboratorioType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Tratamiento de Laboratorio satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tratamiento de Laboratorio: %s', $entity->getNombre()));

            return $this->redirectToRoute('tratamientolaboratorio_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('tratamientolaboratorio/index.html.twig', [
            'tratamlab' => $tratamientoLaboratorioRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="tratamientolaboratorio_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tratamiento = new TratamientoLaboratorio();
        $form = $this->createForm(TratamientoLaboratorioType::class, $tratamiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tratamiento);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tratamiento de Laboratorio satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tratamiento de Laboratorio: %s', $tratamiento->getNombre()));

            return $this->redirectToRoute('tratamientolaboratorio_index');
        }

        return $this->render('tratamientolaboratorio/new.html.twig', [
            'tratamiento' => $tratamiento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tratamientolaboratorio_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TratamientoLaboratorio $tratamientoLaboratorio): Response
    {
        $form = $this->createForm(TratamientoLaboratorioType::class, $tratamientoLaboratorio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tratamiento de Laboratorio satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tratamiento de Laboratorio: %s', $tratamientoLaboratorio->getNombre()));

            return $this->redirectToRoute('tratamientolaboratorio_index');
        }

        return $this->render('tratamientolaboratorio/edit.html.twig', [
            'tratamientolaba' => $tratamientoLaboratorio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tratamientolaboratorio-delete", name="tratamientolaboratorio_delete", methods={"POST"})
     */
    public function tratamientolabDelete(TratamientoLaboratorioRepository $tratamientoLaboratorioRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $tra = $tratamientoLaboratorioRepository->findOneBy(['id' => $q]);
        $em->remove($tra);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Tratamiento de Laboratorio satisfactoriamente!!!');

        return $this->redirectToRoute('tratamientolaboratorio_index');
    }
}