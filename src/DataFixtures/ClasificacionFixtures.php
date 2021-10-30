<?php

namespace App\DataFixtures;

use App\Entity\Clasificacion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClasificacionFixtures extends Fixture
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
        return (new Clasificacion())
            ->setNombre($data['nombreclasificacion']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombreclasificacion' => 'Organico',
                ],
                [
                    'nombreclasificacion' => 'Inorganico',
                ],
                [
                    'nombreclasificacion' => 'Mixto',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}