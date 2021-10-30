<?php

namespace App\Controller;

use App\Entity\GeoSistema;
use App\Form\GeoSistemaType;
use App\Repository\GeoSistemaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/geosistema")
 */
class GeoSistemaController extends AbstractController
{
    /**
     * @Route("/", name="geosistema_index", methods={"GET"})
     */
    public function index(GeoSistemaRepository $geoSistemaRepository): Response
    {
        if ($geoSistemaRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay GeoSistemas almacenados en la Base de Datos!!!');
        }

        return $this->render('geosistema/index.html.twig', [
            'geosist' => $geoSistemaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="geosistema_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $geosist = new GeoSistema();
        $form = $this->createForm(GeoSistemaType::class, $geosist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($geosist);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un GeoSistema satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('GeoSistema: %s', $geosist->getNombre()));

            return $this->redirectToRoute('geosistema_index');
        }

        return $this->render('geosistema/new.html.twig', [
            'gesosist' => $geosist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="geosistema_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GeoSistema $geoSistema): Response
    {
        $form = $this->createForm(GeoSistemaType::class, $geoSistema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un GeoSistema satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('GeoSistema: %s', $geoSistema->getNombre()));

            return $this->redirectToRoute('geosistema_index');
        }

        return $this->render('geosistema/edit.html.twig', [
            'geosist' => $geoSistema,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("geosistema/remove/{id}", name="removergeosistema")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(GeoSistema::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este GeoSistema!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un GeoSistema satisfactoriamente!!!');
        }

        return $this->redirectToRoute('geosistema_index');
    }
}