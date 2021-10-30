<?php

namespace App\Controller;

use App\Entity\TecnicaAplicada;
use App\Form\TecnicaAplicadaType;
use App\Repository\TecnicaAplicadaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/tecnicaaplicada")
 */
class TecnicaAplicadaController extends AbstractController
{
    /**
     * @Route("/", name="tecnicaaplicada_index", methods={"GET","POST"})
     */
    public function index(TecnicaAplicadaRepository $tecnicaAplicadaRepository, Request $request): Response
    {
        if ($tecnicaAplicadaRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Tecnicas Aplicadas almacenados en la Base de Datos!!!');
        }

        $entity = new TecnicaAplicada();
        $form = $this->createForm(TecnicaAplicadaType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Tecnica Aplicada satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tecnica Aplicada: %s', $entity->getNombre()));

            return $this->redirectToRoute('tecnicaaplicada_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        return $this->render('tecnicaaplicada/index.html.twig', [
            'tecnicaapl' => $tecnicaAplicadaRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="tecnicaaplicada_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tecnica = new TecnicaAplicada();
        $form = $this->createForm(TecnicaAplicadaType::class, $tecnica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tecnica);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Tecnica Aplicada satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Tecnica Aplicada: %s', $tecnica->getNombre()));

            return $this->redirectToRoute('tecnicaaplicada_index');
        }

        return $this->render('tecnicaaplicada/new.html.twig', [
            'tecnica' => $tecnica,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tecnicaaplicada_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TecnicaAplicada $tecnicaAplicada): Response
    {
        $form = $this->createForm(TecnicaAplicadaType::class, $tecnicaAplicada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Tecnica Aplicada satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Tecnica Aplicada: %s', $tecnicaAplicada->getNombre()));

            return $this->redirectToRoute('tecnicaaplicada_index');
        }

        return $this->render('tecnicaaplicada/edit.html.twig', [
            'tecnicaaplicada' => $tecnicaAplicada,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tecnicaaplicada-delete", name="tecnicaaplicada_delete", methods={"POST"})
     */
    public function tecnicaaplicadaDelete(TecnicaAplicadaRepository $tecnicaAplicadaRepository, Request $request, EntityManagerInterface $em)
    {
        $q = $request->request->get('delete_id');
        $tec = $tecnicaAplicadaRepository->findOneBy(['id' => $q]);
        $em->remove($tec);
        $em->flush();

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->add('app_error','Se ha eliminado una Tecnica Aplicada satisfactoriamente!!!');

        return $this->redirectToRoute('tecnicaaplicada_index');
    }
}