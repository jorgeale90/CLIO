<?php

namespace App\Controller;

use App\Entity\Objeto;
use App\Form\ObjetoType;
use App\Repository\ObjetoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/objeto")
 */
class ObjetoController extends AbstractController
{
    /**
     * @Route("/", name="objeto_index", methods={"GET"})
     */
    public function index(ObjetoRepository $objetoRepository): Response
    {
        if ($objetoRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Objetos almacenados en la Base de Datos!!!');
        }

        return $this->render('objeto/index.html.twig', [
            'objetos' => $objetoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="objeto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $obje = new Objeto();
        $form = $this->createForm(ObjetoType::class, $obje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($obje);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Objeto satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Objeto: %s', $obje->getNombre()));

            return $this->redirectToRoute('objeto_index');
        }

        return $this->render('objeto/new.html.twig', [
            'obje' => $obje,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="objeto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objeto $objeto): Response
    {
        $form = $this->createForm(ObjetoType::class, $objeto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Objeto satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Objeto: %s', $objeto->getNombre()));

            return $this->redirectToRoute('objeto_index');
        }

        return $this->render('objeto/edit.html.twig', [
            'objeto' => $objeto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("objeto/remove/{id}", name="removerobjeto")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Objeto::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Objeto!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Objeto satisfactoriamente!!!');
        }

        return $this->redirectToRoute('objeto_index');
    }
}