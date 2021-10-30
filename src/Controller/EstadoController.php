<?php

namespace App\Controller;

use App\Entity\Estado;
use App\Form\EstadoType;
use App\Repository\EstadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/estado")
 */
class EstadoController extends AbstractController
{
    /**
     * @Route("/", name="estado_index", methods={"GET","POST"})
     */
    public function index(EstadoRepository $estadoRepository, Request $request): Response
    {
        if ($estadoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Estados almacenados en la Base de Datos!!!');
        }

        $entity = new Estado();
        $form = $this->createForm(EstadoType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Estado satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Estado: %s', $entity->getNombre()));

            return $this->redirectToRoute('estado_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('estado/index.html.twig', [
            'estados' => $estadoRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="estado_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $estado = new Estado();
        $form = $this->createForm(EstadoType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estado);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Estado satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Estado: %s', $estado->getNombre()));

            return $this->redirectToRoute('estado_index');
        }

        return $this->render('estado/new.html.twig', [
            'estado' => $estado,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estado_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Estado $estado): Response
    {
        $form = $this->createForm(EstadoType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Estado satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Estado: %s', $estado->getNombre()));

            return $this->redirectToRoute('estado_index');
        }

        return $this->render('estado/edit.html.twig', [
            'estado' => $estado,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/estado-delete", name="estado_delete", methods={"POST"})
     */
    public function estadoDelete(EstadoRepository $estadoRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $estadoRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Estado satisfactoriamente!!!');

        return $this->redirectToRoute('estado_index');
    }
}