<?php

namespace App\Controller;

use App\Entity\CategoriaDocente;
use App\Form\CategoriaDocenteType;
use App\Repository\CategoriaDocenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/categoriadocente")
 */
class CategoriaDocenteController extends AbstractController
{
    /**
     * @Route("/", name="categoriadocente_index", methods={"GET","POST"})
     */
    public function index(CategoriaDocenteRepository $categoriaDocenteRepository, Request $request): Response
    {
        if ($categoriaDocenteRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Categorías Docentes almacenados en la Base de Datos!!!');
        }

        $entity = new CategoriaDocente();
        $form = $this->createForm(CategoriaDocenteType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría Docente satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría Docente: %s', $entity->getNombre()));

            return $this->redirectToRoute('categoriadocente_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('categoriadocente/index.html.twig', [
            'categorias' => $categoriaDocenteRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="categoriadocente_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoria = new CategoriaDocente();
        $form = $this->createForm(CategoriaDocenteType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría Docente satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría Docente: %s', $categoria->getNombre()));

            return $this->redirectToRoute('categoriadocente_index');
        }

        return $this->render('categoriadocente/new.html.twig', [
            'categoria' => $categoria,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoriadocente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoriaDocente $categoriaDocente): Response
    {
        $form = $this->createForm(CategoriaDocenteType::class, $categoriaDocente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Categoría Docente satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Categoría Docente: %s', $categoriaDocente->getNombre()));

            return $this->redirectToRoute('categoriadocente_index');
        }

        return $this->render('categoriadocente/edit.html.twig', [
            'categoria' => $categoriaDocente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categoriadocente-delete", name="categoriadocente_delete", methods={"POST"})
     */
    public function categoriadocenteDelete(CategoriaDocenteRepository $categoriaDocenteRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $categoriaDocenteRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado una Categoría Docente satisfactoriamente!!!');

        return $this->redirectToRoute('categoriadocente_index');
    }
}