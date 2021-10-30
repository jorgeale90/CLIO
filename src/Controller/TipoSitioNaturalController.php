<?php

namespace App\Controller;

use App\Entity\TipoSitioNatural;
use App\Form\TipoSitioNaturalType;
use App\Repository\TipoSitioNaturalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipositionatural")
 */
class TipoSitioNaturalController extends AbstractController
{
    /**
     * @Route("/", name="tipositionatural_index", methods={"GET"})
     */
    public function index(TipoSitioNaturalRepository $tipoSitioNaturalRepository): Response
    {
        if ($tipoSitioNaturalRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Sitios Naturales almacenados en la Base de Datos!!!');
        }

        return $this->render('tipositionatural/index.html.twig', [
            'tipos' => $tipoSitioNaturalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipositionatural_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoSitioNatural();
        $form = $this->createForm(TipoSitioNaturalType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Sitio Natural satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Sitio Natural: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipositionatural_index');
        }

        return $this->render('tipositionatural/new.html.twig', [
            'tipo' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipositionatural_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoSitioNatural $sitio): Response
    {
        $form = $this->createForm(TipoSitioNaturalType::class, $sitio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Sitio Natural satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Sitio Natural: %s', $sitio->getNombre()));

            return $this->redirectToRoute('tipositionatural_index');
        }

        return $this->render('tipositionatural/edit.html.twig', [
            'sitio' => $sitio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("tipositionatural/remove/{id}", name="removertipositionatural")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TipoSitioNatural::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Tipo de Sitio Natural!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Tipo de Sitio Natural satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tipositionatural_index');
    }
}