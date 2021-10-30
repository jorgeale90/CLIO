<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/foro")
 */
class MainController extends AbstractController
{
    /**
     * @param Request $request HTTP request
     * @param CategoryRepository $categoryRepository Category Repository
     * @param PaginatorInterface $paginator Paginator Interface
     *
     * @return Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route(
     *     "/",
     *     methods={"GET","POST"},
     *     name="main_index",
     * )
     */
    public function index(Request $request, CategoryRepository $categoryRepository, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('App:Category')->findAll();
        $entity = new Category();
        $form = $this->createForm(CategoryType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setDate(new \DateTime('now'));
            $categoryRepository->save($entity);

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Categoría satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Categoría del Foro: %s', $entity->getName()));

            return $this->redirectToRoute('main_index');
        }elseif($form->isSubmitted())
        {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Ha ocurrido un Error!!!');
        }

        $categories = $pagination = $paginator->paginate(
            $categoryRepository->queryAll(),
            $request->query->getInt('page', 1),
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'web/index.html.twig',
            ['categories' => $categories, 'entities' => $entities, 'form' => $form->createView()]
        );
    }

    /**
     * @Route("/{id}/show", name="category_show", methods={"GET","POST"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('App:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Incapaz de encontrar la Categoría.');
        }

        return $this->render('categories/show.html.twig', array(
            'entity'      => $entity,
        ));
    }
}