<?php

namespace App\Controller;

use App\Entity\SubTipoMaterial;
use App\Form\SubTipoMaterialType;
use App\Repository\SubTipoMaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/subtipomaterial")
 */
class SubTipoMaterialController extends AbstractController
{
    /**
     * @Route("/", name="subtipomaterial_index", methods={"GET"})
     */
    public function index(SubTipoMaterialRepository $subTipoMaterialRepository): Response
    {
        if ($subTipoMaterialRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay SubTipos de Materiales almacenados en la Base de Datos!!!');
        }

        return $this->render('subtipomaterial/index.html.twig', [
            'subtipos' => $subTipoMaterialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="subtipomaterial_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subtipo = new SubTipoMaterial();
        $form = $this->createForm(SubTipoMaterialType::class, $subtipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subtipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un SubTipo de Material satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('SubTipo de Material: %s', $subtipo->getNombre()));

            return $this->redirectToRoute('subtipomaterial_index');
        }

        return $this->render('subtipomaterial/new.html.twig', [
            'subtipo' => $subtipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subtipomaterial_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubTipoMaterial $subTipoMaterial): Response
    {
        $form = $this->createForm(SubTipoMaterialType::class, $subTipoMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un SubTipo de Material satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('SubTipo de Material: %s', $subTipoMaterial->getNombre()));

            return $this->redirectToRoute('subtipomaterial_index');
        }

        return $this->render('subtipomaterial/edit.html.twig', [
            'submaterial' => $subTipoMaterial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("subtipomaterial/remove/{id}", name="removersubtipomaterial")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(SubTipoMaterial::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este SubTipo de Material!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un SubTipo de Material satisfactoriamente!!!');
        }

        return $this->redirectToRoute('subtipomaterial_index');
    }
}