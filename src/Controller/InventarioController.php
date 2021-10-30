<?php

namespace App\Controller;

use App\Entity\CartaAutorizacionInventario;
use App\Entity\Inventario;
use App\Entity\OrdenInventario;
use App\Form\InventarioType;
use App\Repository\InventarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/inventario")
 */
class InventarioController extends AbstractController
{
    /**
     * @Route("/", name="inventario_index", methods={"GET"})
     */
    public function index(InventarioRepository $inventarioRepository): Response
    {
        if ($inventarioRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Inventarios almacenados en la Base de Datos!!!');
        }

        return $this->render('inventario/index.html.twig', [
            'invent' => $inventarioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="inventario_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $invent = new Inventario();
        $form = $this->createForm(InventarioType::class, $invent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ordeninventario = $form->get('ordeninventario')->getData();
            foreach($ordeninventario as $orden){
                $fichier = md5(uniqid()) . '.' . $orden->guessExtension();
                $orden->move(
                    $this->getParameter('ordeninventario_directory'),
                    $fichier
                );
                $ord = new OrdenInventario();
                $ord->setLink($fichier);
                $invent->addOrdeninventario($ord);
            }

            $cartaautorizacioninventario = $form->get('cartaautorizacioninventario')->getData();
            foreach($cartaautorizacioninventario as $cart){
                $fichier = md5(uniqid()) . '.' . $cart->guessExtension();
                $cart->move(
                    $this->getParameter('cartaautorizacioninventario_directory'),
                    $fichier
                );
                $carta = new CartaAutorizacionInventario();
                $carta->setLink($fichier);
                $invent->addCartaautorizacioninventario($carta);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invent);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Inventario satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Inventario : %s', $invent->getCodInventario()));

            return $this->redirectToRoute('inventario_index');
        }

        return $this->render('inventario/new.html.twig', [
            'invent' => $invent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inventario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inventario $inventario): Response
    {
        $form = $this->createForm(InventarioType::class, $inventario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ordeninventario = $form->get('ordeninventario')->getData();
            foreach($ordeninventario as $orden){
                $fichier = md5(uniqid()) . '.' . $orden->guessExtension();
                $orden->move(
                    $this->getParameter('ordeninventario_directory'),
                    $fichier
                );
                $ord = new OrdenInventario();
                $ord->setLink($fichier);
                $inventario->addOrdeninventario($ord);
            }

            $cartaautorizacioninventario = $form->get('cartaautorizacioninventario')->getData();
            foreach($cartaautorizacioninventario as $cart){
                $fichier = md5(uniqid()) . '.' . $cart->guessExtension();
                $cart->move(
                    $this->getParameter('cartaautorizacioninventario_directory'),
                    $fichier
                );
                $carta = new CartaAutorizacionInventario();
                $carta->setLink($fichier);
                $inventario->addCartaautorizacioninventario($carta);
            }

            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Inventario satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Inventario : %s', $inventario->getCodInventario()));

            return $this->redirectToRoute('inventario_index');
        }

        return $this->render('inventario/edit.html.twig', [
            'invent' => $inventario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="inventario_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('App:Inventario')->find($id);

        $form = $this->createForm(InventarioType::class, $entities);

        return $this->render('inventario/show.html.twig', array(
            'entities'      => $entities,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("inventario/remove/{id}", name="removerinventario")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Inventario::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Inventario!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Inventario satisfactoriamente!!!');
        }

        return $this->redirectToRoute('inventario_index');
    }

    /**
     * @Route("/eliminarordeninventario/{id}", name="objeto_delete_ordeninv", methods={"DELETE", "GET", "POST"})
     */
    public function deleteOrdenInventario(OrdenInventario $ordenInventario, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$ordenInventario->getId(), $data['_token'])){
            $nom = $ordenInventario->getLink();
            unlink($this->getParameter('ordeninventario_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($ordenInventario);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarcartaautorizacioninventario/{id}", name="objeto_delete_cartainventario", methods={"DELETE", "GET", "POST"})
     */
    public function deleteCartaInventario(CartaAutorizacionInventario $cartaAutorizacionInventario, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$cartaAutorizacionInventario->getId(), $data['_token'])){
            $nom = $cartaAutorizacionInventario->getLink();
            unlink($this->getParameter('cartaautorizacioninventario_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($cartaAutorizacionInventario);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/getobjetoxsitioinvpre", name="objetos_x_sitiosinvpre", methods={"GET","POST"})
     */
    public function getObjetosxSitiosinvpre(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sitiopatrimonial_id = $request->get('sitiopatrimonial_id');
        $fichaobjeto = $em->getRepository('App:FichaObjetoPatrimonial')->findBySitioInvpre($sitiopatrimonial_id);
        return new JsonResponse($fichaobjeto);
    }

    /**
     * @Route("/getobjetoxsitioinv", name="objetos_x_sitiosinv", methods={"GET","POST"})
     */
    public function getObjetosxSitiosinv(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sitiopatrimonial_id = $request->get('sitiopatrimonial_id');
        $fichaobjeto = $em->getRepository('App:FichaObjetoPatrimonial')->findBySitioInv($sitiopatrimonial_id);
        return new JsonResponse($fichaobjeto);
    }
}