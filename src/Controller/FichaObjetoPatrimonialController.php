<?php

namespace App\Controller;

use App\Entity\BibliografiaObjeto;
use App\Entity\DibujoObjeto;
use App\Entity\FichaObjetoPatrimonial;
use App\Entity\FotografiaObjeto;
use App\Entity\FotogrametriaObjeto;
use App\Entity\Modelo3DObjeto;
use App\Entity\PortadaObjeto;
use App\Entity\PublicacionesObjeto;
use App\Entity\ReferenciaWebObjeto;
use App\Filter\FichaObjetoFilterType;
use App\Form\FichaObjetoPatrimonialType;
use App\Form\Type\FichaObjetoPatrimonialShowType;
use App\Repository\FichaObjetoPatrimonialRepository;
use App\Service\NotificationSystem;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user/fichaobjetopatrimonial")
 */
class FichaObjetoPatrimonialController extends AbstractController
{
    public $notifier;

    public $fichaRepository;

    private $em;

    public function __construct(
        NotificationSystem $notifier,
        FichaObjetoPatrimonialRepository $fichaRepository,
        EntityManagerInterface $em)
    {
        $this->notifier = $notifier;
        $this->fichaRepository = $fichaRepository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="fichaobjeto_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, FichaObjetoPatrimonialRepository $fichaObjetoPatrimonialRepository, FilterBuilderUpdaterInterface $query_builder_updater): Response
    {
        if ($fichaObjetoPatrimonialRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Fichas de Objetos Patrimoniales almacenados en la Base de Datos!!!');
        }

        $em = $this->getDoctrine()->getManager();
        $fichao = $em->getRepository('App:FichaObjetoPatrimonial')->findAllTypesQuantityByFicha();

        // initialize a query builder
        $filterBuilder = $this->em->getRepository(FichaObjetoPatrimonial::class)
            ->createQueryBuilder('c')
            ->orderBy('c.codigoobjeto', 'DESC');

        $form = $this->get('form.factory')->create(FichaObjetoFilterType::class);

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

        return $this->render('fichaobjeto/index.html.twig', array(
            'form' => $form->createView(),
            'pagination' => $pagination,
            'fichao' => $fichao
        ));
    }

    /**
     * @Route("/new", name="fichaobjeto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fichaobj = new FichaObjetoPatrimonial();
        $form = $this->createForm(FichaObjetoPatrimonialType::class, $fichaobj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fotografiaobjeto = $form->get('fotografiaobjeto')->getData();
            foreach($fotografiaobjeto as $foto){
                $fichier = md5(uniqid()) . '.' . $foto->guessExtension();
                $foto->move(
                    $this->getParameter('fotografiaobjeto_directory'),
                    $fichier
                );
                $img = new FotografiaObjeto();
                $img->setLink($fichier);
                $fichaobj->addFotografiaobjeto($img);
            }

            $portadaobjeto = $form->get('portadaobjeto')->getData();
            foreach($portadaobjeto as $porta){
                $fichier = md5(uniqid()) . '.' . $porta->guessExtension();
                $porta->move(
                    $this->getParameter('portadaobjeto_directory'),
                    $fichier
                );
                $portad = new PortadaObjeto();
                $portad->setLink($fichier);
                $fichaobj->addPortadaobjeto($portad);
            }

            $dibujoobjeto = $form->get('dibujoobjeto')->getData();
            foreach($dibujoobjeto as $dibujo){
                $fichier = md5(uniqid()) . '.' . $dibujo->guessExtension();
                $dibujo->move(
                    $this->getParameter('dibujoobjeto_directory'),
                    $fichier
                );
                $dib = new DibujoObjeto();
                $dib->setLink($fichier);
                $fichaobj->addDibujoobjeto($dib);
            }

            $fotogrametriaobjeto = $form->get('fotogrametriaobjeto')->getData();
            foreach($fotogrametriaobjeto as $fotogrametria){
                $fichier = md5(uniqid()) . '.' . $fotogrametria->guessExtension();
                $fotogrametria->move(
                    $this->getParameter('fotogrametriaobjeto_directory'),
                    $fichier
                );
                $fotogr = new FotogrametriaObjeto();
                $fotogr->setLink($fichier);
                $fichaobj->addFotogrametriaobjeto($fotogr);
            }

            $modelo3dobjeto = $form->get('modelo3dobjeto')->getData();
            foreach($modelo3dobjeto as $modelo){
                $fichier = md5(uniqid()) . '.' . $modelo->guessExtension();
                $modelo->move(
                    $this->getParameter('modelo3dobjeto_directory'),
                    $fichier
                );
                $model = new Modelo3DObjeto();
                $model->setLink($fichier);
                $fichaobj->addModelo3dobjeto($model);
            }

            $bibliografiaobjeto = $form->get('bibliografiaobjeto')->getData();
            foreach($bibliografiaobjeto as $bibl){
                $fichier = md5(uniqid()) . '.' . $bibl->guessExtension();
                $bibl->move(
                    $this->getParameter('bibliografiaobjeto_directory'),
                    $fichier
                );
                $bibli = new BibliografiaObjeto();
                $bibli->setLink($fichier);
                $fichaobj->addBibliografiaobjeto($bibli);
            }

            $publicacionesobjeto = $form->get('publicacionesobjeto')->getData();
            foreach($publicacionesobjeto as $publi){
                $fichier = md5(uniqid()) . '.' . $publi->guessExtension();
                $publi->move(
                    $this->getParameter('publicacionesobjeto_directory'),
                    $fichier
                );
                $publi = new PublicacionesObjeto();
                $publi->setLink($fichier);
                $fichaobj->addPublicacionesobjeto($publi);
            }

            $referenciawebobjeto = $form->get('referenciawebobjeto')->getData();
            foreach($referenciawebobjeto as $refe){
                $fichier = md5(uniqid()) . '.' . $refe->guessExtension();
                $refe->move(
                    $this->getParameter('referenciawebobjeto_directory'),
                    $fichier
                );
                $refer = new ReferenciaWebObjeto();
                $refer->setLink($fichier);
                $fichaobj->addReferenciawebobjeto($refer);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fichaobj);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado una Ficha del Objeto Patrimonial satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Ficha del Objeto : %s', $fichaobj->getCodigoobjeto()));
            $message = 'Ha Creado una Ficha de Objeto Patrimonial: ' . $fichaobj->getNombreobjeto();
            $this->notifier->sendNotificationToParentUser($message);

            return $this->redirectToRoute('fichaobjeto_index');
        }

        return $this->render('fichaobjeto/new.html.twig', [
            'fichaobj' => $fichaobj,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fichaobjeto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FichaObjetoPatrimonial $fichaObjetoPatrimonial): Response
    {
        $form = $this->createForm(FichaObjetoPatrimonialType::class, $fichaObjetoPatrimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fotografiaobjeto = $form->get('fotografiaobjeto')->getData();
            foreach($fotografiaobjeto as $foto){
                $fichier = md5(uniqid()) . '.' . $foto->guessExtension();
                $foto->move(
                    $this->getParameter('fotografiaobjeto_directory'),
                    $fichier
                );

                $img = new FotografiaObjeto();
                $img->setLink($fichier);
                $fichaObjetoPatrimonial->addFotografiaobjeto($img);
            }

            $dibujoobjeto = $form->get('dibujoobjeto')->getData();
            foreach($dibujoobjeto as $dibujo){
                $fichier = md5(uniqid()) . '.' . $dibujo->guessExtension();
                $dibujo->move(
                    $this->getParameter('dibujoobjeto_directory'),
                    $fichier
                );
                $dib = new DibujoObjeto();
                $dib->setLink($fichier);
                $fichaObjetoPatrimonial->addDibujoobjeto($dib);
            }

            $portadaobjeto = $form->get('portadaobjeto')->getData();
            foreach($portadaobjeto as $porta){
                $fichier = md5(uniqid()) . '.' . $porta->guessExtension();
                $porta->move(
                    $this->getParameter('portadaobjeto_directory'),
                    $fichier
                );
                $portad = new PortadaObjeto();
                $portad->setLink($fichier);
                $fichaObjetoPatrimonial->addPortadaobjeto($portad);
            }

            $fotogrametriaobjeto = $form->get('fotogrametriaobjeto')->getData();
            foreach($fotogrametriaobjeto as $fotogrametria){
                $fichier = md5(uniqid()) . '.' . $fotogrametria->guessExtension();
                $fotogrametria->move(
                    $this->getParameter('fotogrametriaobjeto_directory'),
                    $fichier
                );
                $fotogr = new FotogrametriaObjeto();
                $fotogr->setLink($fichier);
                $fichaObjetoPatrimonial->addFotogrametriaobjeto($fotogr);
            }

            $modelo3dobjeto = $form->get('modelo3dobjeto')->getData();
            foreach($modelo3dobjeto as $modelo){
                $fichier = md5(uniqid()) . '.' . $modelo->guessExtension();
                $modelo->move(
                    $this->getParameter('modelo3dobjeto_directory'),
                    $fichier
                );
                $model = new Modelo3DObjeto();
                $model->setLink($fichier);
                $fichaObjetoPatrimonial->addModelo3dobjeto($model);
            }

            $bibliografiaobjeto = $form->get('bibliografiaobjeto')->getData();
            foreach($bibliografiaobjeto as $bibl){
                $fichier = md5(uniqid()) . '.' . $bibl->guessExtension();
                $bibl->move(
                    $this->getParameter('bibliografiaobjeto_directory'),
                    $fichier
                );
                $bibli = new BibliografiaObjeto();
                $bibli->setLink($fichier);
                $fichaObjetoPatrimonial->addBibliografiaobjeto($bibli);
            }

            $publicacionesobjeto = $form->get('publicacionesobjeto')->getData();
            foreach($publicacionesobjeto as $publi){
                $fichier = md5(uniqid()) . '.' . $publi->guessExtension();
                $publi->move(
                    $this->getParameter('publicacionesobjeto_directory'),
                    $fichier
                );
                $publi = new PublicacionesObjeto();
                $publi->setLink($fichier);
                $fichaObjetoPatrimonial->addPublicacionesobjeto($publi);
            }

            $referenciawebobjeto = $form->get('referenciawebobjeto')->getData();
            foreach($referenciawebobjeto as $refe){
                $fichier = md5(uniqid()) . '.' . $refe->guessExtension();
                $refe->move(
                    $this->getParameter('referenciawebobjeto_directory'),
                    $fichier
                );
                $refer = new ReferenciaWebObjeto();
                $refer->setLink($fichier);
                $fichaObjetoPatrimonial->addReferenciawebobjeto($refer);
            }

            $this->getDoctrine()->getManager()->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado una Ficha de Objeto Patrimonial satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Ficha del Objeto : %s', $fichaObjetoPatrimonial->getCodigoobjeto()));
            $message = 'Ha Actualizado una Ficha de Objeto Patrimonial: ' . $fichaObjetoPatrimonial->getNombreobjeto();
            $this->notifier->sendNotificationToParentUser($message);

            return $this->redirectToRoute('fichaobjeto_index');
        }

        return $this->render('fichaobjeto/edit.html.twig', [
            'fichaObjetoPatrimonial' => $fichaObjetoPatrimonial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="fichaobjeto_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $fichaobjetopat = $em->getRepository('App:FichaObjetoPatrimonial')->find($id);
        $objetointerv = $em->getRepository('App:FichaObjetoPatrimonial')->findOjetoIntervenido($id);

        if (!$fichaobjetopat) {
            throw $this->createNotFoundException('Incapaz de encontrar la Ficha del Objeto Patrimonial.');
        }

        $form = $this->createForm(FichaObjetoPatrimonialShowType::class, $fichaobjetopat);

        return $this->render('fichaobjeto/show.html.twig', array(
            'fich'      => $fichaobjetopat,
            'form' => $form->createView(),
            'objetointerv' => $objetointerv
        ));
    }

    /**
     * @Route("fichaobjetopatrimonial/remove/{id}", name="removerfichaobjetopat")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(FichaObjetoPatrimonial::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra esta Ficha del Objeto Patrimonial!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado una Ficha del Objeto Patrimonial satisfactoriamente!!!');
        }

        return $this->redirectToRoute('fichaobjeto_index');
    }

    /**
     * @Route("/activateobjeto", name="activate_fichaobjeto", methods={"GET","POST"})
     */
    public function activateDiactivateObjeto(Request $request)
    {
        $value = $request->get('value') == 'false' ? false : true;
        $id = $request->get('id');
        $fich = $this->fichaRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $action = 'state';
        if ($fich->getNew()) {
            $fich->setNew(false);
            $action = 'new';
        }
        $message = $value ? 'La Ficha del Objeto Patrimonial ha sido activado' : 'La Ficha del Objeto Patrimonial ha sido desactivado';
        $fich->setState($value);
        $entityManager->persist($fich);
        $entityManager->flush();
        return new JsonResponse(array('response' => $action, 'message' => $message));
    }

    /**
     * @Route("/eliminarfotoobjeto/{id}", name="ficha_delete_fotografia", methods={"DELETE", "GET", "POST"})
     */
    public function deleteFotografiaObjeto(FotografiaObjeto $image, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            $nom = $image->getLink();
            unlink($this->getParameter('fotografiaobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminardibujoobjeto/{id}", name="ficha_delete_dibujo", methods={"DELETE", "GET", "POST"})
     */
    public function deleteDibujoObjeto(DibujoObjeto $dibujoObjeto, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$dibujoObjeto->getId(), $data['_token'])){
            $nom = $dibujoObjeto->getLink();
            unlink($this->getParameter('dibujoobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($dibujoObjeto);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarfotogrametriaobjeto/{id}", name="ficha_delete_fotogrametria", methods={"DELETE", "GET", "POST"})
     */
    public function deleteFotogrametriaObjeto(FotogrametriaObjeto $fotogrametriaObjeto, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$fotogrametriaObjeto->getId(), $data['_token'])){
            $nom = $fotogrametriaObjeto->getLink();
            unlink($this->getParameter('fotogrametriaobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($fotogrametriaObjeto);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarmodelo3dobjeto/{id}", name="ficha_delete_modelo3dobjeto", methods={"DELETE", "GET", "POST"})
     */
    public function deleteModelo3DObjeto(Modelo3DObjeto $modelo3DObjeto, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$modelo3DObjeto->getId(), $data['_token'])){
            $nom = $modelo3DObjeto->getLink();
            unlink($this->getParameter('modelo3dobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($modelo3DObjeto);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarbibliografiaobjeto/{id}", name="ficha_delete_bibliografiaobjeto", methods={"DELETE", "GET", "POST"})
     */
    public function deleteBibliografiaObjeto(BibliografiaObjeto $bibliografiaObjeto, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$bibliografiaObjeto->getId(), $data['_token'])){
            $nom = $bibliografiaObjeto->getLink();
            unlink($this->getParameter('bibliografiaobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($bibliografiaObjeto);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarpublicacionesobjeto/{id}", name="ficha_delete_publicacionesobjeto", methods={"DELETE", "GET", "POST"})
     */
    public function deletePublicacionesObjeto(PublicacionesObjeto $publicacionesObjeto, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$publicacionesObjeto->getId(), $data['_token'])){
            $nom = $publicacionesObjeto->getLink();
            unlink($this->getParameter('publicacionesobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($publicacionesObjeto);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarreferenciawebobjeto/{id}", name="ficha_delete_referenciawebobjeto", methods={"DELETE", "GET", "POST"})
     */
    public function deleteReferenciWebObjeto(ReferenciaWebObjeto $referenciaWebObjeto, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$referenciaWebObjeto->getId(), $data['_token'])){
            $nom = $referenciaWebObjeto->getLink();
            unlink($this->getParameter('referenciawebobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($referenciaWebObjeto);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarportadaobjeto/{id}", name="ficha_delete_portadaobjeto", methods={"DELETE", "GET", "POST"})
     */
    public function deleteportadaObjeto(PortadaObjeto $portadaObjeto, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$portadaObjeto->getId(), $data['_token'])){
            $nom = $portadaObjeto->getLink();
            unlink($this->getParameter('portadaobjeto_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($portadaObjeto);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }
}