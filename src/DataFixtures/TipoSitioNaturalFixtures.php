<?php

namespace App\DataFixtures;

use App\Entity\TipoSitioNatural;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoSitioNaturalFixtures extends Fixture
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
        return (new TipoSitioNatural())
            ->setNombre($data['nombretipositionat']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipositionat' => 'Barrera de Coral',
                ],
                [
                    'nombretipositionat' => 'Blue',
                ],
                [
                    'nombretipositionat' => 'Avion',
                ],
                [
                    'nombretipositionat' => 'Evidencia Aislada',
                ],
                [
                    'nombretipositionat' => 'Puerto',
                ],
                [
                    'nombretipositionat' => 'Fondeadero',
                ],
                [
                    'nombretipositionat' => 'Asentamiento Poblacional',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}