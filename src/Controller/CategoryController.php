<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SettingService;
use App\Form\CategoryForm;
use App\Entity\Category;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/add", name="category_add")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(Request $request, SettingService $setting)
    {
        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);

        $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('app_success','Se ha creado una Categoría satisfactoriamente!!!');
                $flashBag->add('app_success', sprintf('Categoría: %s', $category->getName()));

                return $this->redirectToRoute('category_add');
            }else{
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('app_warning','Ha ocurrido un error a la hora de crear la Categoría. Por favor verifique que el campo contenga solamente letras o números!!!');

                return $this->redirectToRoute('category_add');
            }
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
            'headline' => 'Categories',
            'categories' => $categories,
            'current' => 'category',
            'base' => $setting->get()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="category_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, SettingService $setting, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);
        $categories = $em->getRepository(Category::class)->findAll();

        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);
        
        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('app_warning','Se ha actualizado una Categoría satisfactoriamente!!!');
                $flashBag->add('app_warning', sprintf('Categoría: %s', $category->getName()));

                return $this->redirectToRoute("category_add");
            }
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
            'headline' => 'Edit Category',
            'categories' => $categories,
            'current' => 'category',
            'base' => $setting->get()
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="category_delete")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Category::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Categoría!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Categoría satisfactoriamente!!!');
        }
        return $this->redirectToRoute('category_add');
    }

}
