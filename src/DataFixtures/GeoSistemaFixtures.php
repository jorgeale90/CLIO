<?php

namespace App\DataFixtures;

use App\Entity\GeoSistema;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GeoSistemaFixtures extends Fixture
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
        return (new GeoSistema())
            ->setNombre($data['nombregeosistema']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombregeosistema' => 'Río',
                ],
                [
                    'nombregeosistema' => 'Laguna',
                ],
                [
                    'nombregeosistema' => 'Pantano',
                ],
                [
                    'nombregeosistema' => 'Delta',
                ],
                [
                    'nombregeosistema' => 'Cenote',
                ],
                [
                    'nombregeosistema' => 'Playa',
                ],
                [
                    'nombregeosistema' => 'Duna',
                ],
                [
                    'nombregeosistema' => 'Plataforma',
                ],
                [
                    'nombregeosistema' => 'Bahía',
                ],
                [
                    'nombregeosistema' => 'Manglar',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}