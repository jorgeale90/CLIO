<?php

namespace App\DataFixtures;

use App\Entity\TipoSitio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoSitioCulturalFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $entity = $this->getEntity($data);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function getEntity(array $data)
    {
        return (new TipoSitio())
            ->setNombre($data['nombretipositio']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipositio' => 'Construcción Historica',
                ],
                [
                    'nombretipositio' => 'Area de Interes Patrimonial',
                ],
                [
                    'nombretipositio' => 'Sitio Patrimonial',
                ],
                [
                    'nombretipositio' => 'Evidencia Aislada',
                ],
                [
                    'nombretipositio' => 'Puerto',
                ],
                [
                    'nombretipositio' => 'Fondeadero',
                ],
                [
                    'nombretipositio' => 'Asentamiento Poblacional',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}