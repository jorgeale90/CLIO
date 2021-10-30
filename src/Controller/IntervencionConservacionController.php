<?php

namespace App\Controller;

use App\Entity\CartaAutorizacion;
use App\Entity\IntervencionConservacion;
use App\Entity\ProyectoGeneral;
use App\Form\IntervencionConservacionType;
use App\Repository\IntervencionConservacionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/intervencionconservacion")
 */
class IntervencionConservacionController extends AbstractController
{
    /**
     * @Route("/", name="intervencionconservacion_index", methods={"GET"})
     */
    public function index(IntervencionConservacionRepository $intervencionConservacionRepository): Response
    {
        if ($intervencionConservacionRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Intervenciones de Conservación almacenados en la Base de Datos!!!');
        }

        return $this->render('intervencionconservacion/index.html.twig', [
            'intervcons' => $intervencionConservacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="intervencionconservacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $interv = new IntervencionConservacion();
        $form = $this->createForm(IntervencionConservacionType::class, $interv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $proyectogeneral = $form->get('proyectogeneral')->getData();
            foreach($proyectogeneral as $pro){
                $fichier = md5(uniqid()) . '.' . $pro->guessExtension();
                $pro->move(
                    $this->getParameter('proyectogeneralinter_directory'),
                    $fichier
                );
                $pr = new ProyectoGeneral();
                $pr->setLink($fichier);
                $interv->addProyectogeneral($pr);
            }

            $cartaautorizacion = $form->get('cartaautorizacion')->getData();
            foreach($cartaautorizacion as $car){
                $fichier = md5(uniqid()) . '.' . $car->guessExtension();
                $car->move(
                    $this->getParameter('cartaautorizacioninter_directory'),
                    $fichier
                );
                $cart = new CartaAutorizacion();
                $cart->setLink($fichier);
                $interv->addCartaautorizacion($cart);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($interv);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Intervención de Conservación satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Intervención de Conservación: %s', $interv->getCodIntervencion()));

            return $this->redirectToRoute('intervencionconservacion_index');
        }

        return $this->render('intervencionconservacion/new.html.twig', [
            'interv' => $interv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="intervencionconservacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, IntervencionConservacion $intervencionConservacion): Response
    {
        $form = $this->createForm(IntervencionConservacionType::class, $intervencionConservacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $proyectogeneral = $form->get('proyectogeneral')->getData();
            foreach($proyectogeneral as $pro){
                $fichier = md5(uniqid()) . '.' . $pro->guessExtension();
                $pro->move(
                    $this->getParameter('proyectogeneralinter_directory'),
                    $fichier
                );
                $pr = new ProyectoGeneral();
                $pr->setLink($fichier);
                $intervencionConservacion->addProyectogeneral($pr);
            }

            $cartaautorizacion = $form->get('cartaautorizacion')->getData();
            foreach($cartaautorizacion as $car){
                $fichier = md5(uniqid()) . '.' . $car->guessExtension();
                $car->move(
                    $this->getParameter('cartaautorizacioninter_directory'),
                    $fichier
                );
                $cart = new CartaAutorizacion();
                $cart->setLink($fichier);
                $intervencionConservacion->addCartaautorizacion($cart);
            }

            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Intervención de Conservación satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Intervención de Conservación: %s', $intervencionConservacion->getCodIntervencion()));

            return $this->redirectToRoute('intervencionconservacion_index');
        }

        return $this->render('intervencionconservacion/edit.html.twig', [
            'intervcons' => $intervencionConservacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="intervencionconservacion_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('App:IntervencionConservacion')->find($id);

        $form = $this->createForm(IntervencionConservacionType::class, $entities);

        return $this->render('intervencionconservacion/show.html.twig', array(
            'entities'      => $entities,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("intervencionconservacion/remove/{id}", name="removerintervencionconservacion")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(IntervencionConservacion::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Intervención de Conservación!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Intervención de Conservación satisfactoriamente!!!');
        }

        return $this->redirectToRoute('intervencionconservacion_index');
    }

    /**
     * @Route("/eliminarproyectogeneralinter/{id}", name="objeto_delete_proyec", methods={"DELETE", "GET", "POST"})
     */
    public function deleteProyectoGeneral(ProyectoGeneral $proyectoGeneral, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$proyectoGeneral->getId(), $data['_token'])){
            $nom = $proyectoGeneral->getLink();
            unlink($this->getParameter('proyectogeneralinter_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($proyectoGeneral);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarcartaautorizinter/{id}", name="objeto_delete_cartaauto", methods={"DELETE", "GET", "POST"})
     */
    public function deleteCartaAutorizacion(CartaAutorizacion $cartaAutorizacion, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$cartaAutorizacion->getId(), $data['_token'])){
            $nom = $cartaAutorizacion->getLink();
            unlink($this->getParameter('cartaautorizacioninter_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($cartaAutorizacion);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/getobjetoxsitio", name="objetos_x_sitios", methods={"GET","POST"})
     */
    public function getObjetosxSitios(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sitiopatrimonial_id = $request->get('sitiopatrimonial_id');
        $fichaobjeto = $em->getRepository('App:FichaObjetoPatrimonial')->findBySitio($sitiopatrimonial_id);
        return new JsonResponse($fichaobjeto);
    }
}