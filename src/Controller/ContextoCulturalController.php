<?php

namespace App\Controller;

use App\Entity\ContextoCultural;
use App\Form\ContextoCulturalType;
use App\Repository\ContextoCulturalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/contextocultural")
 */
class ContextoCulturalController extends AbstractController
{
    /**
     * @Route("/", name="contextocultural_index", methods={"GET"})
     */
    public function index(ContextoCulturalRepository $contextoCulturalRepository): Response
    {
        if ($contextoCulturalRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Contextos Culturales almacenados en la Base de Datos!!!');
        }

        return $this->render('contextocultural/index.html.twig', [
            'contexto' => $contextoCulturalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contextocultural_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contexto = new ContextoCultural();
        $form = $this->createForm(ContextoCulturalType::class, $contexto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contexto);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Contexto Cultural satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Contexto Cultural: %s', $contexto->getNombre()));

            return $this->redirectToRoute('contextocultural_index');
        }

        return $this->render('contextocultural/new.html.twig', [
            'contexto' => $contexto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contextocultural_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ContextoCultural $contextoCultural): Response
    {
        $form = $this->createForm(ContextoCulturalType::class, $contextoCultural);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Contexto Cultural satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Contexto Cultural: %s', $contextoCultural->getNombre()));

            return $this->redirectToRoute('contextocultural_index');
        }

        return $this->render('contextocultural/edit.html.twig', [
            'contexto' => $contextoCultural,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("contextocultural/remove/{id}", name="removercontextocultural")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ContextoCultural::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Contexto Cultural!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Contexto Cultural satisfactoriamente!!!');
        }

        return $this->redirectToRoute('contextocultural_index');
    }
}