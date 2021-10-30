<?php

namespace App\Controller;

use App\Entity\UsoFuncion;
use App\Form\UsoFuncionType;
use App\Repository\UsoFuncionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/usofuncion")
 */
class UsoFuncionController extends AbstractController
{
    /**
     * @Route("/", name="usofuncion_index", methods={"GET"})
     */
    public function index(UsoFuncionRepository $usoFuncionRepository): Response
    {
        if ($usoFuncionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Usos de Funciones almacenados en la Base de Datos!!!');
        }

        return $this->render('usofuncion/index.html.twig', [
            'usosfun' => $usoFuncionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="usofuncion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $usofun = new UsoFuncion();
        $form = $this->createForm(UsoFuncionType::class, $usofun);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usofun);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Uso/Función satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Uso/Función: %s', $usofun->getNombre()));

            return $this->redirectToRoute('usofuncion_index');
        }

        return $this->render('usofuncion/new.html.twig', [
            'usofun' => $usofun,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usofuncion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UsoFuncion $usoFuncion): Response
    {
        $form = $this->createForm(UsoFuncionType::class, $usoFuncion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Uso/Función satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Uso/Función: %s', $usoFuncion->getNombre()));

            return $this->redirectToRoute('usofuncion_index');
        }

        return $this->render('usofuncion/edit.html.twig', [
            'usoFuncion' => $usoFuncion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("usofuncion/remove/{id}", name="removerusofuncion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(UsoFuncion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Uso de Función!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Uso de Función satisfactoriamente!!!');
        }

        return $this->redirectToRoute('usofuncion_index');
    }
}