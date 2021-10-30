<?php

namespace App\Controller;

use App\Entity\Organismo;
use App\Form\OrganismoType;
use App\Repository\OrganismoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/organismo")
 */
class OrganismoController extends AbstractController
{
    /**
     * @Route("/", name="organismo_index", methods={"GET","POST"})
     */
    public function index(OrganismoRepository $organismoRepository, Request $request): Response
    {
        if ($organismoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Organismos almacenados en la Base de Datos!!!');
        }

        $entity = new Organismo();
        $form = $this->createForm(OrganismoType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Organismo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Organismo: %s', $entity->getNombre()));

            return $this->redirectToRoute('organismo_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('organismo/index.html.twig', [
            'organismos' => $organismoRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="organismo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $organismo = new Organismo();
        $form = $this->createForm(OrganismoType::class, $organismo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organismo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Organismo satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Organismo: %s', $organismo->getNombre()));

            return $this->redirectToRoute('organismo_index');
        }

        return $this->render('organismo/new.html.twig', [
            'organismo' => $organismo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="organismo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Organismo $organismo): Response
    {
        $form = $this->createForm(OrganismoType::class, $organismo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Organismo satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Organismo: %s', $organismo->getNombre()));

            return $this->redirectToRoute('organismo_index');
        }

        return $this->render('organismo/edit.html.twig', [
            'organismo' => $organismo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/organismo-delete", name="organismo_delete", methods={"POST"})
     */
    public function organismoDelete(OrganismoRepository $organismoRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $organismoRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Organismo satisfactoriamente!!!');

        return $this->redirectToRoute('organismo_index');
    }
}