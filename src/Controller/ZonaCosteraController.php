<?php

namespace App\Controller;

use App\Entity\ZonaCostera;
use App\Form\ZonaCosteraType;
use App\Repository\ZonaCosteraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/zonacostera")
 */
class ZonaCosteraController extends AbstractController
{
    /**
     * @Route("/", name="zonacostera_index", methods={"GET"})
     */
    public function index(ZonaCosteraRepository $zonaCosteraRepository): Response
    {
        if ($zonaCosteraRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Zonas Costeras almacenadas en la Base de Datos!!!');
        }

        return $this->render('zonacostera/index.html.twig', [
            'zonas' => $zonaCosteraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="zonacostera_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $zona = new ZonaCostera();
        $form = $this->createForm(ZonaCosteraType::class, $zona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($zona);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Zona Costera satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Zona Costera: %s', $zona->getNombre()));

            return $this->redirectToRoute('zonacostera_index');
        }

        return $this->render('zonacostera/new.html.twig', [
            'zona' => $zona,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="zonacostera_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ZonaCostera $zonaCostera): Response
    {
        $form = $this->createForm(ZonaCosteraType::class, $zonaCostera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Zona Costera satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Zona Costera: %s', $zonaCostera->getNombre()));

            return $this->redirectToRoute('zonacostera_index');
        }

        return $this->render('zonacostera/edit.html.twig', [
            'zona' => $zonaCostera,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("zonacostera/remove/{id}", name="removerzonacostera")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(ZonaCostera::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Zona Costera!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Zona Costera satisfactoriamente!!!');
        }

        return $this->redirectToRoute('zonacostera_index');
    }
}