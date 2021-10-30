<?php

namespace App\Controller;

use App\Repository\SettingsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\SettingsFormType;
use App\Entity\Settings;

/**
 * @Route("/user/settings")
 */
class SettingsController extends AbstractController
{
    /**
     * @Route("/", name="settings_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(SettingsRepository $settingsRepository): Response
    {
        return $this->render('settings/index.html.twig', [
            'settings' => $settingsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="settings_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request)
    {
        $settings = new Settings();
        $form = $this->createForm(SettingsFormType::class, $settings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($settings);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Ajuste del Blog satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Ajuste: %s', $settings->getPageName()));

            return $this->redirectToRoute('settings_index');
        }

        return $this->render('settings/new.html.twig', [
            'setting' => $settings,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/edit", name="settings_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Settings $settings): Response
    {
        $form = $this->createForm(SettingsFormType::class, $settings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Ajuste satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Ajuste: %s', $settings->getPageName()));

            return $this->redirectToRoute('settings_index');
        }

        return $this->render('settings/edit.html.twig', [
            'settings' => $settings,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="settings_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Settings::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Ajuste!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Ajuste satisfactoriamente!!!');
        }

        return $this->redirectToRoute('settings_index');
    }
}
