<?php

namespace App\Controller;

use App\Entity\Nacionalidad;
use App\Form\NacionalidadType;
use App\Repository\NacionalidadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/nacionalidad")
 */
class NacionalidadController extends AbstractController
{
    /**
     * @Route("/", name="nacionalidad_index", methods={"GET","POST"})
     */
    public function index(NacionalidadRepository $nacionalidadRepository, Request $request): Response
    {
        if ($nacionalidadRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Nacionalidades almacenados en la Base de Datos!!!');
        }

        $entity = new Nacionalidad();
        $form = $this->createForm(NacionalidadType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Nacionalidad satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Nacionalidad: %s', $entity->getNombre()));

            return $this->redirectToRoute('nacionalidad_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('nacionalidad/index.html.twig', [
            'nacionalidades' => $nacionalidadRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="nacionalidad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $nacionalidad = new Nacionalidad();
        $form = $this->createForm(NacionalidadType::class, $nacionalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nacionalidad);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Nacionalidad satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Nacionalidad: %s', $nacionalidad->getNombre()));

            return $this->redirectToRoute('nacionalidad_index');
        }

        return $this->render('nacionalidad/new.html.twig', [
            'nacionalidad' => $nacionalidad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nacionalidad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nacionalidad $nacionalidad): Response
    {
        $form = $this->createForm(NacionalidadType::class, $nacionalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Nacionalidad satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Nacionalidad: %s', $nacionalidad->getNombre()));

            return $this->redirectToRoute('nacionalidad_index');
        }

        return $this->render('nacionalidad/edit.html.twig', [
            'nacionalidad' => $nacionalidad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nacionalidad-delete", name="nacionalidad_delete", methods={"POST"})
     */
    public function nacionalidadDelete(NacionalidadRepository $nacionalidadRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $entity = $nacionalidadRepository->findOneBy(['id' => $q]);
        $em->remove($entity);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado una Nacionalidad satisfactoriamente!!!');

        return $this->redirectToRoute('nacionalidad_index');
    }

    /**
     * @Route("/getmunicipiolocxprovincialoc", name="municipioloc_x_provincialoc", methods={"GET","POST"})
     */
    public function getMunicipiolocxProvincialoc(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $municipio = $em->getRepository('App:Municipio')->findByProvincialoc($provincia_id);
        return new JsonResponse($municipio);
    }
}