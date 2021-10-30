<?php

namespace App\Controller;

use App\Entity\Especialista;
use App\Form\Type\EspecialistaShowType;
use App\Form\EspecialistaType;
use App\Repository\EspecialistaRepository;
use App\Service\NotificationSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Filter\EspecialistaFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;

/**
 * Class EspecialistaController
 * @package App\Controller
 * @Route("user/especialist")
 */
class EspecialistaController extends AbstractController
{

    public $notifier;

    public $especialistaRepository;

    public $encoder;

    private $em;

    public function __construct(
        NotificationSystem $notifier,
        EspecialistaRepository $especialistaRepository,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em)
    {
        $this->notifier = $notifier;
        $this->especialistaRepository = $especialistaRepository;
        $this->encoder = $encoder;
        $this->em = $em;
    }

    /**
     * @Route("/", name="especialist")
     */
    public function index(Request $request, PaginatorInterface $paginator, EspecialistaRepository $especialistaRepository, FilterBuilderUpdaterInterface $query_builder_updater)
    {
        if ($especialistaRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Especialistas almacenados en la Base de Datos!!!');
        }

        $em = $this->getDoctrine()->getManager();
        $tipo = $em->getRepository('App:Especialista')->findAllTypesQuantityByInvestigador();

        // initialize a query builder
        $filterBuilder = $this->em->getRepository(Especialista::class)
            ->createQueryBuilder('c')
            ->orderBy('c.noReg', 'DESC');

        $form = $this->get('form.factory')->create(EspecialistaFilterType::class);

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));
            $query_builder_updater->addFilterConditions($form, $filterBuilder);
        }

        $query = $filterBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('especialista/index.html.twig', array(
            'form' => $form->createView(),
            'pagination' => $pagination,
            'tipo' => $tipo
        ));
    }

    /**
     * @Route("/new", name="especialist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $especialist = new Especialista();
        $form = $this->createForm(EspecialistaType::class, $especialist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $especialist = $this->encodePasswordEspecialist($especialist);
            $entityManager->persist($especialist);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success', 'Se ha creado un nuevo especialista satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Especialista: %s', $especialist->getCredentials()->getFirstname()));
            $message = 'Ha creado el especialista: ' . $especialist->getCredentials()->getFirstname() . ' ' . $especialist->getCredentials()->getLastname();
            $this->notifier->sendNotificationToParentUser($message);

            return $this->redirectToRoute('especialist');
        }

        return $this->render('especialista/new.html.twig', [
            'especialista' => $especialist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activate", name="activate_especialist", methods={"GET","POST"})
     */
    public function activateDiactivateEspecialist(Request $request)
    {
        $value = $request->get('value') == 'false' ? false : true;
        $id = $request->get('id');
        $especialist = $this->especialistaRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $action = 'state';
        if ($especialist->getNew()) {
            $especialist->setNew(false);
            $action = 'new';
        }
        $message = $value ? 'El especialista ha sido activado' : 'El especialista ha sido desactivado';
        $especialist->setState($value);
        $especialist->getCredentials()->setStatus($value);
        $entityManager->persist($especialist);
        $entityManager->flush();
        return new JsonResponse(array('response' => $action, 'message' => $message));
    }

    /**
     * @param $id
     * @Route("/delete/{id}", name="delete_especialist")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete($id)
    {
        $especialist = $this->especialistaRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($especialist);
        $entityManager->flush();
        return $this->redirectToRoute('especialist');
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/edit/{id}", name="edit_especialist", methods={"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, $id)
    {
        $especialist = $this->especialistaRepository->find($id);
        $form = $this->createEspecialistForm($especialist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $especialist = $this->encodePasswordEspecialist($especialist);
            $entityManager->persist($especialist);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning', 'Se ha modificado el especialista satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Especialista: %s', $especialist->getCredentials()->getFirstname()));
            $message = 'Ha modificado el especialista: ' . $especialist->getCredentials()->getFirstname() . ' ' . $especialist->getCredentials()->getLastname();
            $this->notifier->sendNotificationToParentUser($message);

            return $this->redirectToRoute('especialist');
        }

        return $this->render('especialista/edit.html.twig', [
            'especialista' => $especialist,
            'form' => $form->createView(),
        ]);
    }

    protected function createEspecialistForm(Especialista $especialist, $action = 'new')
    {
        return $this->createForm(EspecialistaType::class, $especialist, array('editar' => true));
    }

    protected function encodePasswordEspecialist(Especialista $especialist) {
        $credentials = $especialist->getCredentials();
        if ($especialist->getState()) {
            $especialist->setNew(false);
            $credentials->setStatus(true);
        }
        if ($credentials->getRoles()[0] == 'ROLE_ADMIN') {
            $credentials->setIsadmin(true);
        }
        $password = $this->encoder->encodePassword($credentials, $credentials->getPassword());
        $credentials->setPassword($password);
        $especialist->setCredentials($credentials);
        return $especialist;
    }

    /**
     * @Route("/{id}/show", name="especialista_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $especialista = $em->getRepository('App:Especialista')->find($id);

        if (!$especialista) {
            throw $this->createNotFoundException('Incapaz de encontrar el Especialista.');
        }

        $form = $this->createForm(EspecialistaShowType::class, $especialista);

        return $this->render('especialista/show.html.twig', array(
            'especiali'      => $especialista,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/getmunicipioexprovinciae", name="municipioe_x_provinciae", methods={"GET","POST"})
     */
    public function getMunicipioexProvinciae(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $muni = $em->getRepository('App:Municipio')->findByProvinciae($provincia_id);
        return new JsonResponse($muni);
    }

    /**
     * @Route("/getprovinciaexpaise", name="provinciae_x_paise", methods={"GET","POST"})
     */
    public function getProvinciaexPaise(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pais_id = $request->get('pais_id');
        $provincia = $em->getRepository('App:Provincia')->findByPaise($pais_id);
        return new JsonResponse($provincia);
    }
}
