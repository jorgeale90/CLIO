<?php

namespace App\Controller;

use App\Entity\Bibliografias;
use App\Entity\Declaracion;
use App\Entity\PlanManejo;
use App\Entity\PortadaSitio;
use App\Form\Type\FichaObjetoPatrimonialShowType;
use App\Form\Type\SitioPatrimonialShowType;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Croquis;
use App\Entity\Fotogrametria;
use App\Entity\Modelo3D;
use App\Entity\Planimetria;
use App\Entity\Publicaciones;
use App\Entity\ReferenciaWeb;
use App\Entity\SitioPatrimonial;
use App\Entity\Fotografia;
use App\Entity\Video;
use App\Form\SitioPatrimonialType;
use App\Repository\SitioPatrimonialRepository;
use App\Service\NotificationSystem;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Filter\SitioPatrimonialFilterType;

/**
 * @Route("/user/sitiopatrimonial")
 */
class SitioPatrimonialController extends AbstractController
{
    public $notifier;

    public $sitioRepository;

    private $em;

    public function __construct(
        NotificationSystem $notifier,
        SitioPatrimonialRepository $sitioRepository,
        EntityManagerInterface $em)
    {
        $this->notifier = $notifier;
        $this->sitioRepository = $sitioRepository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="sitiopatrimonial_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, SitioPatrimonialRepository $sitioPatrimonialRepository, FilterBuilderUpdaterInterface $query_builder_updater)
    {
        if ($sitioPatrimonialRepository->findAll() == null) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No hay Sitios Patrimoniales almacenados en la Base de Datos!!!');
        }

        $em = $this->getDoctrine()->getManager();
        $sitio = $em->getRepository('App:SitioPatrimonial')->findAllTypesQuantityBySitio();

        // initialize a query builder
        $filterBuilder = $this->em->getRepository(SitioPatrimonial::class)
            ->createQueryBuilder('c')
            ->orderBy('c.codigo', 'DESC');

        $form = $this->get('form.factory')->create(SitioPatrimonialFilterType::class);

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

        return $this->render('sitiopatrimonial/index.html.twig', array(
            'form' => $form->createView(),
            'pagination' => $pagination,
            'sitio' => $sitio
        ));
    }

    /**
     * @Route("/new", name="sitiopatrimonial_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sitio = new SitioPatrimonial();
        $form = $this->createForm(SitioPatrimonialType::class, $sitio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fotografias = $form->get('fotografias')->getData();
            // Hacemos un bucle en las imágenes
            foreach($fotografias as $foto){
                // Generamos un nuevo nombre de archivo
                $fichier = md5(uniqid()) . '.' . $foto->guessExtension();
                // Copiamos el archivo a la carpeta de subidas
                $foto->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // Almacenamos la imagen en la base de datos (su nombre)
                $img = new Fotografia();
                $img->setLink($fichier);
                $sitio->addFotografia($img);
            }

            $portadasitio = $form->get('portadasitio')->getData();
            foreach($portadasitio as $porta){
                $fichier = md5(uniqid()) . '.' . $porta->guessExtension();
                $porta->move(
                    $this->getParameter('portadasitio_directory'),
                    $fichier
                );

                $portada= new PortadaSitio();
                $portada->setLink($fichier);
                $sitio->addPortadasitio($portada);
            }

            $planimetria = $form->get('planimetria')->getData();
            foreach($planimetria as $plani){
                $fichier = md5(uniqid()) . '.' . $plani->guessExtension();
                $plani->move(
                    $this->getParameter('planimetria_directory'),
                    $fichier
                );

                $plan= new Planimetria();
                $plan->setLink($fichier);
                $sitio->addPlanimetrium($plan);
            }

            $croquis = $form->get('croquis')->getData();
            foreach($croquis as $cro){
                $fichier = md5(uniqid()) . '.' . $cro->guessExtension();
                $cro->move(
                    $this->getParameter('croquis_directory'),
                    $fichier
                );

                $croq= new Croquis();
                $croq->setLink($fichier);
                $sitio->addCroqui($croq);
            }

            $fotogrametria = $form->get('fotogrametria')->getData();
            foreach($fotogrametria as $fotogra){
                $fichier = md5(uniqid()) . '.' . $fotogra->guessExtension();
                $fotogra->move(
                    $this->getParameter('fotogrametria_directory'),
                    $fichier
                );

                $fot= new Fotogrametria();
                $fot->setLink($fichier);
                $sitio->addFotogrametrium($fot);
            }

            $video = $form->get('video')->getData();
            foreach($video as $vi){
                $fichier = md5(uniqid()) . '.' . $vi->guessExtension();
                $vi->move(
                    $this->getParameter('video_directory'),
                    $fichier
                );

                $vid= new Video();
                $vid->setLink($fichier);
                $sitio->addVideo($vid);
            }

            $modelo3d = $form->get('modelo3d')->getData();
            foreach($modelo3d as $mode){
                $fichier = md5(uniqid()) . '.' . $mode->guessExtension();
                $mode->move(
                    $this->getParameter('modelo3d_directory'),
                    $fichier
                );

                $model= new Modelo3D();
                $model->setLink($fichier);
                $sitio->addModelo3d($model);
            }

            $bibliografia = $form->get('bibliografia')->getData();
            foreach($bibliografia as $biblio){
                $fichier = md5(uniqid()) . '.' . $biblio->guessExtension();
                $biblio->move(
                    $this->getParameter('bibliografia_directory'),
                    $fichier
                );

                $bib= new Bibliografias();
                $bib->setLink($fichier);
                $sitio->addBibliografium($bib);
            }

            $publicaciones = $form->get('publicaciones')->getData();
            foreach($publicaciones as $publica){
                $fichier = md5(uniqid()) . '.' . $publica->guessExtension();
                $publica->move(
                    $this->getParameter('publicaciones_directory'),
                    $fichier
                );

                $publ= new Publicaciones();
                $publ->setLink($fichier);
                $sitio->addPublicacione($publ);
            }

            $referenciaweb = $form->get('referenciaweb')->getData();
            foreach($referenciaweb as $refe){
                $fichier = md5(uniqid()) . '.' . $refe->guessExtension();
                $refe->move(
                    $this->getParameter('referenciaweb_directory'),
                    $fichier
                );

                $ref= new ReferenciaWeb();
                $ref->setLink($fichier);
                $sitio->addReferenciaweb($ref);
            }

            $plan = $form->get('plan')->getData();
            foreach($plan as $planm){
                $fichier = md5(uniqid()) . '.' . $planm->guessExtension();
                $planm->move(
                    $this->getParameter('planmanejo_directory'),
                    $fichier
                );

                $pla= new PlanManejo();
                $pla->setLink($fichier);
                $sitio->addPlan($pla);
            }

            $declaracion = $form->get('declaracion')->getData();
            foreach($declaracion as $decla){
                $fichier = md5(uniqid()) . '.' . $decla->guessExtension();
                $decla->move(
                    $this->getParameter('declaracion_directory'),
                    $fichier
                );

                $dec= new Declaracion();
                $dec->setLink($fichier);
                $sitio->addDeclaracion($dec);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sitio);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_success','Se ha creado un Sitio Patrimonial satisfactoriamente!!!');
            $flashBag->add('app_success', sprintf('Sitio Patrimonial: %s', $sitio->getNombre()));
            $message = 'Ha Creado un Sitio Patrimonial: ' . $sitio->getNombre();
            $this->notifier->sendNotificationToParentUser($message);

            return $this->redirectToRoute('sitiopatrimonial_index');
        }

        return $this->render('sitiopatrimonial/new.html.twig', [
            'sitio' => $sitio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sitiopatrimonial_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, SitioPatrimonial $sitioPatrimonial, EntityManagerInterface $entityManager): Response
    {
        if (null === $sitioPatrimonial = $entityManager->getRepository(SitioPatrimonial::class)->find($id)) {
            throw $this->createNotFoundException('No se encontro ningun Elemento para este ID '.$id);
        }

        $original = new ArrayCollection();
        foreach ($sitioPatrimonial->getCoordenadasgps() as $coordenadasgp) {
            $original->add($coordenadasgp);
        }

        $originalUTM = new ArrayCollection();
        foreach ($sitioPatrimonial->getCoordenadasutm() as $coordenadasutm) {
            $originalUTM->add($coordenadasutm);
        }

        $originalobjeto = new ArrayCollection();
        foreach ($sitioPatrimonial->getZonaobjetogps() as $zonaobjetogp) {
            $originalobjeto->add($zonaobjetogp);
        }

        $originalpatri = new ArrayCollection();
        foreach ($sitioPatrimonial->getZonapatrimonialgps() as $zonapatrimonialgp) {
            $originalpatri->add($zonapatrimonialgp);
        }

        $originalprote = new ArrayCollection();
        foreach ($sitioPatrimonial->getZonaprotecciongps() as $zonaprotecciongp) {
            $originalprote->add($zonaprotecciongp);
        }

        $originalinsert = new ArrayCollection();
        foreach ($sitioPatrimonial->getZonainsertidumbregps() as $zonainsertidumbregp) {
            $originalinsert->add($zonainsertidumbregp);
        }

        $form = $this->createForm(SitioPatrimonialType::class, $sitioPatrimonial, array('editar' => true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Eliminar la relacion
            foreach ($original as $coordenadasgp) {
                if (false === $sitioPatrimonial->getCoordenadasgps()->contains($coordenadasgp)) {
                    // Eliminar Coordenada para el Sitio
                    $entityManager->persist($coordenadasgp);
                    // Elimino la coordenada por completo
                    $entityManager->remove($coordenadasgp);
                }
            }

            foreach ($originalUTM as $coordenadasutm) {
                if (false === $sitioPatrimonial->getCoordenadasutm()->contains($coordenadasutm)) {
                    $entityManager->persist($coordenadasutm);
                    $entityManager->remove($coordenadasutm);
                }
            }

            foreach ($originalobjeto as $zonaobjetogp) {
                if (false === $sitioPatrimonial->getZonaobjetogps()->contains($zonaobjetogp)) {
                    $entityManager->persist($zonaobjetogp);
                    $entityManager->remove($zonaobjetogp);
                }
            }

            foreach ($originalpatri as $zonapatrimonialgp) {
                if (false === $sitioPatrimonial->getZonapatrimonialgps()->contains($zonapatrimonialgp)) {
                    $entityManager->persist($zonapatrimonialgp);
                    $entityManager->remove($zonapatrimonialgp);
                }
            }

            foreach ($originalprote as $zonaprotecciongp) {
                if (false === $sitioPatrimonial->getZonaprotecciongps()->contains($zonaprotecciongp)) {
                    $entityManager->persist($zonaprotecciongp);
                    $entityManager->remove($zonaprotecciongp);
                }
            }

            foreach ($originalinsert as $zonainsertidumbregp) {
                if (false === $sitioPatrimonial->getZonainsertidumbregps()->contains($zonainsertidumbregp)) {
                    $entityManager->persist($zonainsertidumbregp);
                    $entityManager->remove($zonainsertidumbregp);
                }
            }

            $fotografias = $form->get('fotografias')->getData();
            foreach($fotografias as $foto){
                $fichier = md5(uniqid()) . '.' . $foto->guessExtension();
                $foto->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Fotografia();
                $img->setLink($fichier);
                $sitioPatrimonial->addFotografia($img);
            }

            $portadasitio = $form->get('portadasitio')->getData();
            foreach($portadasitio as $porta){
                $fichier = md5(uniqid()) . '.' . $porta->guessExtension();
                $porta->move(
                    $this->getParameter('portadasitio_directory'),
                    $fichier
                );

                $portada= new PortadaSitio();
                $portada->setLink($fichier);
                $sitioPatrimonial->addPortadasitio($portada);
            }

            $planimetria = $form->get('planimetria')->getData();
            foreach($planimetria as $plani){
                $fichier = md5(uniqid()) . '.' . $plani->guessExtension();
                $plani->move(
                    $this->getParameter('planimetria_directory'),
                    $fichier
                );

                $plan= new Planimetria();
                $plan->setLink($fichier);
                $sitioPatrimonial->addPlanimetrium($plan);
            }

            $croquis = $form->get('croquis')->getData();
            foreach($croquis as $cro){
                $fichier = md5(uniqid()) . '.' . $cro->guessExtension();
                $cro->move(
                    $this->getParameter('croquis_directory'),
                    $fichier
                );

                $croq= new Croquis();
                $croq->setLink($fichier);
                $sitioPatrimonial->addCroqui($croq);
            }

            $fotogrametria = $form->get('fotogrametria')->getData();
            foreach($fotogrametria as $fotogra){
                $fichier = md5(uniqid()) . '.' . $fotogra->guessExtension();
                $fotogra->move(
                    $this->getParameter('fotogrametria_directory'),
                    $fichier
                );

                $fot= new Fotogrametria();
                $fot->setLink($fichier);
                $sitioPatrimonial->addFotogrametrium($fot);
            }

            $video = $form->get('video')->getData();
            foreach($video as $vi){
                $fichier = md5(uniqid()) . '.' . $vi->guessExtension();
                $vi->move(
                    $this->getParameter('video_directory'),
                    $fichier
                );

                $vid= new Video();
                $vid->setLink($fichier);
                $sitioPatrimonial->addVideo($vid);
            }

            $modelo3d = $form->get('modelo3d')->getData();
            foreach($modelo3d as $mode){
                $fichier = md5(uniqid()) . '.' . $mode->guessExtension();
                $mode->move(
                    $this->getParameter('modelo3d_directory'),
                    $fichier
                );

                $model= new Modelo3D();
                $model->setLink($fichier);
                $sitioPatrimonial->addModelo3d($model);
            }

            $bibliografia = $form->get('bibliografia')->getData();
            foreach($bibliografia as $biblio){
                $fichier = md5(uniqid()) . '.' . $biblio->guessExtension();
                $biblio->move(
                    $this->getParameter('bibliografia_directory'),
                    $fichier
                );

                $bib= new Bibliografias();
                $bib->setLink($fichier);
                $sitioPatrimonial->addBibliografium($bib);
            }

            $publicaciones = $form->get('publicaciones')->getData();
            foreach($publicaciones as $publica){
                $fichier = md5(uniqid()) . '.' . $publica->guessExtension();
                $publica->move(
                    $this->getParameter('publicaciones_directory'),
                    $fichier
                );

                $publ= new Publicaciones();
                $publ->setLink($fichier);
                $sitioPatrimonial->addPublicacione($publ);
            }

            $referenciaweb = $form->get('referenciaweb')->getData();
            foreach($referenciaweb as $refe){
                $fichier = md5(uniqid()) . '.' . $refe->guessExtension();
                $refe->move(
                    $this->getParameter('referenciaweb_directory'),
                    $fichier
                );

                $ref= new ReferenciaWeb();
                $ref->setLink($fichier);
                $sitioPatrimonial->addReferenciaweb($ref);
            }

            $plan = $form->get('plan')->getData();
            foreach($plan as $planm){
                $fichier = md5(uniqid()) . '.' . $planm->guessExtension();
                $planm->move(
                    $this->getParameter('planmanejo_directory'),
                    $fichier
                );

                $pla= new PlanManejo();
                $pla->setLink($fichier);
                $sitioPatrimonial->addPlan($pla);
            }

            $declaracion = $form->get('declaracion')->getData();
            foreach($declaracion as $decla){
                $fichier = md5(uniqid()) . '.' . $decla->guessExtension();
                $decla->move(
                    $this->getParameter('declaracion_directory'),
                    $fichier
                );

                $dec= new Declaracion();
                $dec->setLink($fichier);
                $sitioPatrimonial->addDeclaracion($dec);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sitioPatrimonial);
            $entityManager->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','Se ha actualizado un Sitio Patrimonial satisfactoriamente!!!');
            $flashBag->add('app_warning', sprintf('Sitio Patrimonial: %s', $sitioPatrimonial->getNombre()));
            $message = 'Ha Actualizado un Sitio Patrimonial: ' . $sitioPatrimonial->getNombre();
            $this->notifier->sendNotificationToParentUser($message);

            return $this->redirectToRoute('sitiopatrimonial_index');
        }

        return $this->render('sitiopatrimonial/edit.html.twig', [
            'sitio' => $sitioPatrimonial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="sitiopatrimonial_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $sitioPatrimonial = $em->getRepository('App:SitioPatrimonial')->find($id);
        $sitioobjeto = $em->getRepository('App:SitioPatrimonial')->findSitioObjeto($id);

        if (!$sitioPatrimonial) {
            throw $this->createNotFoundException('Incapaz de encontrar el Sitio Patrimonial.');
        }

        $form = $this->createForm(SitioPatrimonialShowType::class, $sitioPatrimonial);

        return $this->render('sitiopatrimonial/show.html.twig', array(
            'sitio'      => $sitioPatrimonial,
            'form' => $form->createView(),
            'sitioobjeto' => $sitioobjeto
        ));
    }

    /**
     * @Route("sitiopatrimonial/remove/{id}", name="removersitiopatrimonial")
     */
    public function remove(Request $request, $id, SitioPatrimonial $sitioPatrimonial)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(SitioPatrimonial::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Sitio Patrimonial!!!');
        } else {
//            if ($entity->getFotografias() != null) {
//            $image = new Fotografia();
////                $this->remove('images_directory')->remove($entity->getFotografias());
//                $nom = $image->getLink();
//                unlink($this->getParameter('images_directory').'/'.$nom);
//            }
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Sitio Patrimonial satisfactoriamente!!!');
        }

        return $this->redirectToRoute('sitiopatrimonial_index');
    }

    /**
     * @Route("/getprovinciasxpaiss", name="provincias_x_paiss", methods={"GET","POST"})
     */
    public function getProvinciasxPaiss(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pais_id = $request->get('pais_id');
        $provincia = $em->getRepository('App:Provincia')->findByPaiss($pais_id);
        return new JsonResponse($provincia);
    }

    /**
     * @Route("/getmunicipioxprovincia", name="municipio_x_provincia", methods={"GET","POST"})
     */
    public function getMunicipioxProvincia(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $muni = $em->getRepository('App:Municipio')->findByProvincia($provincia_id);
        return new JsonResponse($muni);
    }

    /**
     * @Route("/getconsejopxmunicipio", name="consejop_x_municipio", methods={"GET","POST"})
     */
    public function getConsejoPxMunicipio(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $conse = $em->getRepository('App:ConsejoPopular')->findByMunicipio($municipio_id);
        return new JsonResponse($conse);
    }

    /**
     * @Route("/activate", name="activate_sitiopatrimonial", methods={"GET","POST"})
     */
    public function activateDiactivateSitio(Request $request)
    {
        $value = $request->get('value') == 'false' ? false : true;
        $id = $request->get('id');
        $sitio = $this->sitioRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $action = 'state';
        if ($sitio->getNew()) {
            $sitio->setNew(false);
            $action = 'new';
        }
        $message = $value ? 'El Sitio Patrimonial ha sido activado' : 'El Sitio Patrimonial ha sido desactivado';
        $sitio->setState($value);
        $entityManager->persist($sitio);
        $entityManager->flush();
        return new JsonResponse(array('response' => $action, 'message' => $message));
    }

    /**
     * @Route("/eliminarfoto/{id}", name="sitio_delete_fotografia", methods={"DELETE", "GET", "POST"})
     */
    public function deleteImage(Fotografia $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // Comprobamos si el token es válido
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // Obtenemos el nombre de la imagen
            $nom = $image->getLink();
            // Borramos el archivo
            unlink($this->getParameter('images_directory').'/'.$nom);

            // Eliminamos la entrada de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // Respondemos en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarportadasitio/{id}", name="sitio_delete_portadasitio", methods={"DELETE", "GET", "POST"})
     */
    public function deletePortadaSitio(PortadaSitio $portadaSitio, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$portadaSitio->getId(), $data['_token'])){
            $nom = $portadaSitio->getLink();
            unlink($this->getParameter('portadasitio_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($portadaSitio);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarplanimetria/{id}", name="sitio_delete_planimetria", methods={"DELETE", "GET", "POST"})
     */
    public function deletePlanimetria(Planimetria $planimetria, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$planimetria->getId(), $data['_token'])){
            $nom = $planimetria->getLink();
            unlink($this->getParameter('planimetria_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($planimetria);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarcroquis/{id}", name="sitio_delete_croquis", methods={"DELETE", "GET", "POST"})
     */
    public function deleteCroquis(Croquis $croquis, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$croquis->getId(), $data['_token'])){
            $nom = $croquis->getLink();
            unlink($this->getParameter('croquis_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($croquis);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarfotogrametria/{id}", name="sitio_delete_fotogrametria", methods={"DELETE", "GET", "POST"})
     */
    public function deleteFotogrametria(Fotogrametria $fotogrametria, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$fotogrametria->getId(), $data['_token'])){
            $nom = $fotogrametria->getLink();
            unlink($this->getParameter('fotogrametria_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($fotogrametria);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarvideo/{id}", name="sitio_delete_video", methods={"DELETE", "GET", "POST"})
     */
    public function deleteVideo(Video $video, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$video->getId(), $data['_token'])){
            $nom = $video->getLink();
            unlink($this->getParameter('video_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($video);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarmodelo3d/{id}", name="sitio_delete_modelo3d", methods={"DELETE", "GET", "POST"})
     */
    public function deleteModelo3D(Modelo3D $modelo3D, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$modelo3D->getId(), $data['_token'])){
            $nom = $modelo3D->getLink();
            unlink($this->getParameter('modelo3d_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($modelo3D);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarbibliografia/{id}", name="sitio_delete_bibliografia", methods={"DELETE", "GET", "POST"})
     */
    public function deleteBibliografia(Bibliografias $bibliografias, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$bibliografias->getId(), $data['_token'])){
            $nom = $bibliografias->getLink();
            unlink($this->getParameter('bibliografia_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($bibliografias);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarpublicaciones/{id}", name="sitio_delete_publicaciones", methods={"DELETE", "GET"})
     */
    public function deletePublicaciones(Publicaciones $publicaciones, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$publicaciones->getId(), $data['_token'])){
            $nom = $publicaciones->getLink();
            unlink($this->getParameter('publicaciones_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($publicaciones);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarreferenciaweb/{id}", name="sitio_delete_referenciaweb", methods={"DELETE", "GET"})
     */
    public function deleteReferenciaWeb(ReferenciaWeb $referenciaWeb, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$referenciaWeb->getId(), $data['_token'])){
            $nom = $referenciaWeb->getLink();
            unlink($this->getParameter('referenciaweb_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($referenciaWeb);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminarplanmanejo/{id}", name="sitio_delete_planmanejo", methods={"DELETE", "GET", "POST"})
     */
    public function deletePlanmanejo(PlanManejo $plan, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$plan->getId(), $data['_token'])){
            $nom = $plan->getLink();
            unlink($this->getParameter('planmanejo_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($plan);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }

    /**
     * @Route("/eliminardeclaracion/{id}", name="sitio_delete_declaracion", methods={"DELETE", "GET", "POST"})
     */
    public function deleteDeclaracion(Declaracion $declaracion, Request $request){
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$declaracion->getId(), $data['_token'])){
            $nom = $declaracion->getLink();
            unlink($this->getParameter('declaracion_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($declaracion);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalido'], 400);
        }
    }
}