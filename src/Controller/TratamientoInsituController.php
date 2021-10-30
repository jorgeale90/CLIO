<?php

namespace App\Controller;

use App\Entity\TratamientoInsitu;
use App\Form\TratamientoInsituType;
use App\Repository\TratamientoInsituRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tratamientoinsitu")
 */
class TratamientoInsituController extends AbstractController
{
    /**
     * @Route("/", name="tratamientoinsitu_index", methods={"GET","POST"})
     */
    public function index(TratamientoInsituRepository $tratamientoInsituRepository, Request $request): Response
    {
        if ($tratamientoInsituRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tratamiento Insitu almacenados en la Base de Datos!!!');
        }

        $entity = new TratamientoInsitu();
        $form = $this->createForm(TratamientoInsituType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Tratamiento Insitu satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tratamiento Insitu: %s', $entity->getNombre()));

            return $this->redirectToRoute('tratamientoinsitu_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('tratamientoinsitu/index.html.twig', [
            'tratamins' => $tratamientoInsituRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="tratamientoinsitu_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tratamiento = new TratamientoInsitu();
        $form = $this->createForm(TratamientoInsituType::class, $tratamiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tratamiento);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Tratamiento Insitu satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tratamiento Insitu: %s', $tratamiento->getNombre()));

            return $this->redirectToRoute('tratamientoinsitu_index');
        }

        return $this->render('tratamientoinsitu/new.html.twig', [
            'tratamiento' => $tratamiento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tratamientoinsitu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TratamientoInsitu $tratamientoInsitu): Response
    {
        $form = $this->createForm(TratamientoInsituType::class, $tratamientoInsitu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Tratamiento Insitu satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tratamiento Insitu: %s', $tratamientoInsitu->getNombre()));

            return $this->redirectToRoute('tratamientoinsitu_index');
        }

        return $this->render('tratamientoinsitu/edit.html.twig', [
            'tratamientoins' => $tratamientoInsitu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tratamientoinsitu-delete", name="tratamientoinsitu_delete", methods={"POST"})
     */
    public function tratamientoinsDelete(TratamientoInsituRepository $tratamientoInsituRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $tra = $tratamientoInsituRepository->findOneBy(['id' => $q]);
        $em->remove($tra);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado un Tratamiento Insitu satisfactoriamente!!!');

        return $this->redirectToRoute('tratamientoinsitu_index');
    }
}