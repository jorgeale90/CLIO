<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/user")
 */
class MapaController extends AbstractController
{
    /**
     * @Route("/mapa", name="app_mapa", methods={"GET","POST"})
     */
    public function Mapa()
    {
        return $this->render('home/mapa.html.twig');
    }

    /**
     * @Route("/localizacion", name="app_localizacion", methods={"GET","POST"})
     */
    public function LocalizacionSitios(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('search');
        $sitios = $em->getRepository('App:SitioPatrimonial')->findAllSitiosDataArray($searchParam);
        $features = [];
        foreach ($sitios as $sitio) {
            $features[] = [
                'type' => 'Feature',
                'properties' => array(
                    "title" => $sitio['nombre'],
                    'description' => $sitio['otros_nombre'] ? '('.$sitio['otros_nombre'].')' : '(Sin especificar)',
                    'allProps' => $sitio
                ),
                'geometry' => $this->getArrayCoordenates($sitio)
            ];
        }
        $data = ['type' => 'FeatureCollection', 'features' => $features];
        return new JsonResponse($data);
    }

    private function getArrayCoordenates($sitio)
    {
        $geometry = [
            'type' => sizeof($sitio['coordenadasgps']) == 1 ? 'Point' : 'Polygon',
            'coordinates' => null
        ];
        $coordinates = [];
        foreach ($sitio['coordenadasgps'] as $coordenadagp) {
            if (sizeof($sitio['coordenadasgps']) == 1) {
                $coordinates = [(float)$coordenadagp['longitud'], (float)$coordenadagp['latitud']];
            } else {
                array_push($coordinates, [(float)$coordenadagp['longitud'], (float)$coordenadagp['latitud']]);
            }
        }
        $geometry['coordinates'] = sizeof($sitio['coordenadasgps']) == 1 ? $coordinates : [$coordinates];
        return $geometry;
    }

    /**
     * @Route("/zonas_gps", name="app_zonas_gps", methods={"GET","POST"})
     */
    public function getZones(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $siteId = $request->get('id');
        $zone = $request->get('zone');
        $coordinates = $em->getRepository('App:'.$zone)->findBy(array('sitiopatrimonial' => $siteId));
        $polygonCoordinates = [];
        foreach ($coordinates as $coordinate) {
            switch ($zone) {
                case 'ZonaInsertidumbreGPS':
                    array_push($polygonCoordinates, [$coordinate->getLatitudinsert(), $coordinate->getLongitudinsert()]);
                    break;
                case 'ZonaObjetoGPS':
                    array_push($polygonCoordinates, [$coordinate->getLatitudobjeto(), $coordinate->getLongitudobjeto()]);
                    break;
                case 'ZonaPatrimonialGPS':
                    array_push($polygonCoordinates, [$coordinate->getLatitudpatrimonial(), $coordinate->getLongitudpatrimonial()]);
                    break;
                case 'ZonaProteccionGPS':
                    array_push($polygonCoordinates, [$coordinate->getLatitudproteccion(), $coordinate->getLongitudproteccion()]);
                    break;
            }
        }
        return new JsonResponse($polygonCoordinates);
    }
}