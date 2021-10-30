<?php

namespace App\Controller;

use App\Entity\CausaIntervencionObjeto;
use App\Form\CausaIntervencionObjetoType;
use App\Repository\CausaIntervencionObjetoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/causaintervencionobjeto")
 */
class CausaIntervencionObjetoController extends AbstractController
{
    /**
     * @Route("/", name="causaintervencionobj_index", methods={"GET","POST"})
     */
    public function index(CausaIntervencionObjetoRepository $causaIntervencionObjetoRepository, Request $request): Response
    {
        if ($causaIntervencionObjetoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Causas de Intervención del Objeto almacenados en la Base de Datos!!!');
        }

        $entity = new CausaIntervencionObjeto();
        $form = $this->createForm(CausaIntervencionObjetoType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Causa de Intervención del Objeto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Causa de Intervención del Objeto: %s', $entity->getNombre()));

            return $this->redirectToRoute('causaintervencionobj_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('causaintervencionobjeto/index.html.twig', [
            'causaint' => $causaIntervencionObjetoRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="causaintervencionobjeto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $causa = new CausaIntervencionObjeto();
        $form = $this->createForm(CausaIntervencionObjetoType::class, $causa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($causa);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Causa de Intervención del Objeto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Causa de Intervención del Objeto: %s', $causa->getNombre()));

            return $this->redirectToRoute('causaintervencionobj_index');
        }

        return $this->render('causaintervencionobjeto/new.html.twig', [
            'causainter' => $causa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="causaintervencionobj_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CausaIntervencionObjeto $causaIntervencionObjeto): Response
    {
        $form = $this->createForm(CausaIntervencionObjetoType::class, $causaIntervencionObjeto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Causa de Intervencion del Objeto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Causa de Intervencion del Objeto: %s', $causaIntervencionObjeto->getNombre()));

            return $this->redirectToRoute('causaintervencionobj_index');
        }

        return $this->render('causaintervencionobjeto/edit.html.twig', [
            'causainterobje' => $causaIntervencionObjeto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/causaintervencionobjeto-delete", name="causaintervencionobjeto_delete", methods={"POST"})
     */
    public function causaintervencionobjetoDelete(CausaIntervencionObjetoRepository $causaIntervencionObjetoRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $causa = $causaIntervencionObjetoRepository->findOneBy(['id' => $q]);
        $em->remove($causa);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado una Causa de Intervencion del Objeto satisfactoriamente!!!');

        return $this->redirectToRoute('causaintervencionobj_index');
    }
}