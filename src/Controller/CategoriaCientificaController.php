<?php

namespace App\Controller;

use App\Entity\CategoriaCientifica;
use App\Form\CategoriaCientificaType;
use App\Repository\CategoriaCientificaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/categoriacientifica")
 */
class CategoriaCientificaController extends AbstractController
{
    /**
     * @Route("/", name="categoriacientifica_index", methods={"GET","POST"})
     */
    public function index(CategoriaCientificaRepository $categoriaCientificaRepository, Request $request): Response
    {
        if ($categoriaCientificaRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Categorías Científicas almacenados en la Base de Datos!!!');
        }

        $entity = new CategoriaCientifica();
        $form = $this->createForm(CategoriaCientificaType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría Científica satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría Científica: %s', $entity->getNombre()));

            return $this->redirectToRoute('categoriacientifica_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('categoriacientifica/index.html.twig', [
            'categoriacient' => $categoriaCientificaRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="categoriacientifica_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoriacient = new CategoriaCientifica();
        $form = $this->createForm(CategoriaCientificaType::class, $categoriacient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoriacient);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría Científica satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría Científica: %s', $categoriacient->getNombre()));

            return $this->redirectToRoute('categoriacientifica_index');
        }

        return $this->render('categoriacientifica/new.html.twig', [
            'categoriacient' => $categoriacient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoriacientifica_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoriaCientifica $categoriaCientifica): Response
    {
        $form = $this->createForm(CategoriaCientificaType::class, $categoriaCientifica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Categoría Científica satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Categoría Científica: %s', $categoriaCientifica->getNombre()));

            return $this->redirectToRoute('categoriacientifica_index');
        }

        return $this->render('categoriacientifica/edit.html.twig', [
            'categoriacient' => $categoriaCientifica,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categoriacientifica-delete", name="categoriacientifica_delete", methods={"POST"})
     */
    public function categoriacientificaDelete(CategoriaCientificaRepository $categoriaCientificaRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $categoriaCientificaRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado una Categoría Científica satisfactoriamente!!!');

        return $this->redirectToRoute('categoriacientifica_index');
    }
}