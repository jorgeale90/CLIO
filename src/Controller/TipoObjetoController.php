<?php

namespace App\Controller;

use App\Entity\TipoObjeto;
use App\Form\TipoObjetoType;
use App\Repository\TipoObjetoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipoobjeto")
 */
class TipoObjetoController extends AbstractController
{
    /**
     * @Route("/", name="tipoobjeto_index", methods={"GET"})
     */
    public function index(TipoObjetoRepository $tipoObjetoRepository): Response
    {
        if ($tipoObjetoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Objetos almacenados en la Base de Datos!!!');
        }

        return $this->render('tipoobjeto/index.html.twig', [
            'tipos' => $tipoObjetoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipoobjeto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoObjeto();
        $form = $this->createForm(TipoObjetoType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Objeto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Objeto: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipoobjeto_index');
        }

        return $this->render('tipoobjeto/new.html.twig', [
            'tipo' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipoobjeto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoObjeto $objeto): Response
    {
        $form = $this->createForm(TipoObjetoType::class, $objeto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Objeto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Objeto: %s', $objeto->getNombre()));

            return $this->redirectToRoute('tipoobjeto_index');
        }

        return $this->render('tipoobjeto/edit.html.twig', [
            'objeto' => $objeto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("tipoobjeto/remove/{id}", name="removertipoobjeto")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TipoObjeto::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Tipo de Objeto!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Tipo de Objeto satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tipoobjeto_index');
    }
}