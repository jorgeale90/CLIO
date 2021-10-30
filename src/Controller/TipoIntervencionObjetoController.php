<?php

namespace App\Controller;

use App\Entity\TipoIntervencionObjeto;
use App\Form\TipoIntervencionObjetoType;
use App\Repository\TipoIntervencionObjetoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipointervencionobjeto")
 */
class TipoIntervencionObjetoController extends AbstractController
{
    /**
     * @Route("/", name="tipointervencionobjeto_index", methods={"GET","POST"})
     */
    public function index(TipoIntervencionObjetoRepository $tipoIntervencionObjetoRepository, Request $request): Response
    {
        if ($tipoIntervencionObjetoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Intervenciones de Objetos almacenados en la Base de Datos!!!');
        }

        $entity = new TipoIntervencionObjeto();
        $form = $this->createForm(TipoIntervencionObjetoType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Intervención de Objeto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Intervención: %s', $entity->getNombre()));

            return $this->redirectToRoute('tipointervencionobjeto_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('tipointervencionobjeto/index.html.twig', [
            'tipointer' => $tipoIntervencionObjetoRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="tipointervencionobjeto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoIntervencionObjeto();
        $form = $this->createForm(TipoIntervencionObjetoType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Intervención de Objeto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Intervención de Objeto: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipointervencionobjeto_index');
        }

        return $this->render('tipointervencionobjeto/new.html.twig', [
            'tip' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipointervencionobjeto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoIntervencionObjeto $tipoIntervencionObjeto): Response
    {
        $form = $this->createForm(TipoIntervencionObjetoType::class, $tipoIntervencionObjeto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Intervención de Objeto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Intervención de Objeto: %s', $tipoIntervencionObjeto->getNombre()));

            return $this->redirectToRoute('tipointervencionobjeto_index');
        }

        return $this->render('tipointervencionobjeto/edit.html.twig', [
            'tipoint' => $tipoIntervencionObjeto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tipointervencionobjeto-delete", name="tipointervencionobjeto_delete", methods={"POST"})
     */
    public function tipointervencionobjetoDelete(TipoIntervencionObjetoRepository $tipoIntervencionObjetoRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $tipointerobj = $tipoIntervencionObjetoRepository->findOneBy(['id' => $q]);
        $em->remove($tipointerobj);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Tipo de Intervención de Objeto satisfactoriamente!!!');

        return $this->redirectToRoute('tipointervencionobjeto_index');
    }
}