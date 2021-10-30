<?php

namespace App\Controller;

use App\Filter\SitioPatrimonialKeyFilterType;
use App\Repository\SitioPatrimonialRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/keys")
 */
class KeyWordController extends AbstractController
{
    /**
     * @Route("/", name="sitiopatrimonial_keyword", methods={"GET"})
     */
    public function keyword(Request $request, PaginatorInterface $paginator, SitioPatrimonialRepository $sitioPatrimonialRepository)
    {
        if ($sitioPatrimonialRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Sitios Patrimoniales almacenados en la Base de Datos!!!');
        }

        $em = $this->getDoctrine()->getManager();
        $sitio = $em->getRepository('App:SitioPatrimonial')->findAllTypesQuantityBySitio();

        // initialize a query builder
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:SitioPatrimonial')
            ->createQueryBuilder('e');

        $form = $this->get('form.factory')->create(SitioPatrimonialKeyFilterType::class);

        if ($request->query->has($form->getName())) {
            // manually bind values from the request
            $form->submit($request->query->get($form->getName()));

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
        }

        $query = $filterBuilder->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('home/key.html.twig', array(
            'form' => $form->createView(),
            'pagination' => $pagination,
            'sitio' => $sitio
        ));
    }
}