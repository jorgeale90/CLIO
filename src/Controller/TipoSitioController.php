<?php

namespace App\Controller;

use App\Entity\TipoSitio;
use App\Form\TipoSitioType;
use App\Repository\TipoSitioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipositio")
 */
class TipoSitioController extends AbstractController
{
    /**
     * @Route("/", name="tipositio_index", methods={"GET"})
     */
    public function index(TipoSitioRepository $tipoSitioRepository): Response
    {
        if ($tipoSitioRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Sitios almacenados en la Base de Datos!!!');
        }

        return $this->render('tipositio/index.html.twig', [
            'tipos' => $tipoSitioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipositio_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoSitio();
        $form = $this->createForm(TipoSitioType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Sitio satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Sitio: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipositio_index');
        }

        return $this->render('tipositio/new.html.twig', [
            'tipo' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipositio_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoSitio $sitio): Response
    {
        $form = $this->createForm(TipoSitioType::class, $sitio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Sitio satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Sitio: %s', $sitio->getNombre()));

            return $this->redirectToRoute('tipositio_index');
        }

        return $this->render('tipositio/edit.html.twig', [
            'sitio' => $sitio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("tipositio/remove/{id}", name="removertipositio")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TipoSitio::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Tipo de Sitio!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Tipo de Sitio satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tipositio_index');
    }
}