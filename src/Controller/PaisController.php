<?php

namespace App\Controller;

use App\Entity\Pais;
use App\Form\PaisType;
use App\Repository\PaisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/pais")
 */
class PaisController extends AbstractController
{
    /**
     * @Route("/", name="pais_index", methods={"GET","POST"})
     */
    public function index(PaisRepository $paisRepository, Request $request): Response
    {
        if ($paisRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Paises almacenados en la Base de Datos!!!');
        }

        $entity = new Pais();
        $form = $this->createForm(PaisType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un País satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('País: %s', $entity->getNombre()));

            return $this->redirectToRoute('pais_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('pais/index.html.twig', [
            'paises' => $paisRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="pais_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pais = new Pais();
        $form = $this->createForm(PaisType::class, $pais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pais);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un País satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('País: %s', $pais->getNombre()));

            return $this->redirectToRoute('pais_index');
        }

        return $this->render('pais/new.html.twig', [
            'pais' => $pais,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pais_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pais $pais): Response
    {
        $form = $this->createForm(PaisType::class, $pais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un País satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('País: %s', $pais->getNombre()));

            return $this->redirectToRoute('pais_index');
        }

        return $this->render('pais/edit.html.twig', [
            'pais' => $pais,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pais-delete", name="pais_delete", methods={"POST"})
     */
    public function paisDelete(PaisRepository $paisRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $pais = $paisRepository->findOneBy(['id' => $q]);
        $em->remove($pais);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un País satisfactoriamente!!!');

        return $this->redirectToRoute('pais_index');
    }
}