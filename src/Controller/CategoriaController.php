<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/categoria")
 */
class CategoriaController extends AbstractController
{
    /**
     * @Route("/", name="categoria_index", methods={"GET"})
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        if ($categoriaRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Categorías almacenados en la Base de Datos!!!');
        }

        return $this->render('categoria/index.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categoria_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría: %s', $categoria->getNombre()));

            return $this->redirectToRoute('categoria_index');
        }

        return $this->render('categoria/new.html.twig', [
            'categoria' => $categoria,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoria_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categoria $categoria): Response
    {
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Categoría satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Categoría: %s', $categoria->getNombre()));

            return $this->redirectToRoute('categoria_index');
        }

        return $this->render('categoria/edit.html.twig', [
            'categoria' => $categoria,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("categoria/remove/{id}", name="removercategoria")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Categoria::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Categoría!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Categoría satisfactoriamente!!!');
        }

        return $this->redirectToRoute('categoria_index');
    }
}