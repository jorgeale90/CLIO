<?php

namespace App\Controller;

use App\Entity\CategoriaObjeto;
use App\Form\CategoriaObjetoType;
use App\Repository\CategoriaObjetoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/categoriaobjeto")
 */
class CategoriaObjetoController extends AbstractController
{
    /**
     * @Route("/", name="categoriaobjeto_index", methods={"GET"})
     */
    public function index(CategoriaObjetoRepository $categoriaObjetoRepository): Response
    {
        if ($categoriaObjetoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Categorías de Objetos almacenados en la Base de Datos!!!');
        }

        return $this->render('categoriaobjeto/index.html.twig', [
            'categoriasobj' => $categoriaObjetoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categoriaobjeto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoriaobj = new CategoriaObjeto();
        $form = $this->createForm(CategoriaObjetoType::class, $categoriaobj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoriaobj);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría de Objeto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría de Objeto: %s', $categoriaobj->getNombre()));

            return $this->redirectToRoute('categoriaobjeto_index');
        }

        return $this->render('categoriaobjeto/new.html.twig', [
            'categoriaobj' => $categoriaobj,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoriaobjeto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoriaObjeto $categoriaObjeto): Response
    {
        $form = $this->createForm(CategoriaObjetoType::class, $categoriaObjeto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Categoría de Objeto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Categoría de Objeto: %s', $categoriaObjeto->getNombre()));

            return $this->redirectToRoute('categoriaobjeto_index');
        }

        return $this->render('categoriaobjeto/edit.html.twig', [
            'categoriaobj' => $categoriaObjeto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("categoriaobjeto/remove/{id}", name="removercategoriaobjeto")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(CategoriaObjeto::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Categoría de Objeto!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Categoría de Objeto satisfactoriamente!!!');
        }

        return $this->redirectToRoute('categoriaobjeto_index');
    }
}