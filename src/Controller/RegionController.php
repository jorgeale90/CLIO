<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/region")
 */
class RegionController extends AbstractController
{
    /**
     * @Route("/", name="region_index", methods={"GET"})
     */
    public function index(RegionRepository $regionRepository): Response
    {
        if ($regionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Regiones almacenadas en la Base de Datos!!!');
        }

        return $this->render('region/index.html.twig', [
            'regiones' => $regionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="region_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $regi = new Region();
        $form = $this->createForm(RegionType::class, $regi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($regi);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Región satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Región: %s', $regi->getNombre()));

            return $this->redirectToRoute('region_index');
        }

        return $this->render('region/new.html.twig', [
            'regi' => $regi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="region_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Region $region): Response
    {
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Región satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Región: %s', $region->getNombre()));

            return $this->redirectToRoute('region_index');
        }

        return $this->render('region/edit.html.twig', [
            'regi' => $region,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("region/remove/{id}", name="removerregion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Region::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Región!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Región satisfactoriamente!!!');
        }

        return $this->redirectToRoute('region_index');
    }
}