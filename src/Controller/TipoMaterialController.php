<?php

namespace App\Controller;

use App\Entity\TipoMaterial;
use App\Form\TipoMaterialType;
use App\Repository\TipoMaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tipomaterial")
 */
class TipoMaterialController extends AbstractController
{
    /**
     * @Route("/", name="tipomaterial_index", methods={"GET"})
     */
    public function index(TipoMaterialRepository $tipoMaterialRepository): Response
    {
        if ($tipoMaterialRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tipos de Materiales almacenados en la Base de Datos!!!');
        }

        return $this->render('tipomaterial/index.html.twig', [
            'tipos' => $tipoMaterialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipomaterial_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipo = new TipoMaterial();
        $form = $this->createForm(TipoMaterialType::class, $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipo);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tipo de Material satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tipo de Material: %s', $tipo->getNombre()));

            return $this->redirectToRoute('tipomaterial_index');
        }

        return $this->render('tipomaterial/new.html.twig', [
            'tipo' => $tipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipomaterial_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoMaterial $material): Response
    {
        $form = $this->createForm(TipoMaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tipo de Material satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tipo de Material: %s', $material->getNombre()));

            return $this->redirectToRoute('tipomaterial_index');
        }

        return $this->render('tipomaterial/edit.html.twig', [
            'material' => $material,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("tipomaterial/remove/{id}", name="removertipomaterial")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(TipoMaterial::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Tipo de Material!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Tipo de Material satisfactoriamente!!!');
        }

        return $this->redirectToRoute('tipomaterial_index');
    }
}