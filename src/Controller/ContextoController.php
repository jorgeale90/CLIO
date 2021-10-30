<?php

namespace App\Controller;

use App\Entity\Contexto;
use App\Form\ContextoType;
use App\Repository\ContextoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/contexto")
 */
class ContextoController extends AbstractController
{
    /**
     * @Route("/", name="contexto_index", methods={"GET"})
     */
    public function index(ContextoRepository $contextoRepository): Response
    {
        if ($contextoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Contextos almacenados en la Base de Datos!!!');
        }

        return $this->render('contexto/index.html.twig', [
            'context' => $contextoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contexto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $conte = new Contexto();
        $form = $this->createForm(ContextoType::class, $conte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conte);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Contexto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Contexto: %s', $conte->getNombre()));

            return $this->redirectToRoute('contexto_index');
        }

        return $this->render('contexto/new.html.twig', [
            'conte' => $conte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contexto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contexto $contexto): Response
    {
        $form = $this->createForm(ContextoType::class, $contexto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Contexto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Contexto: %s', $contexto->getNombre()));

            return $this->redirectToRoute('contexto_index');
        }

        return $this->render('contexto/edit.html.twig', [
            'contexto' => $contexto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("contexto/remove/{id}", name="removercontexto")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Contexto::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Contexto!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Contexto satisfactoriamente!!!');
        }

        return $this->redirectToRoute('contexto_index');
    }
}