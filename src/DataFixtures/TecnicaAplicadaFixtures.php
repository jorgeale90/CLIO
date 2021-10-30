<?php

namespace App\DataFixtures;

use App\Entity\TecnicaAplicada;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TecnicaAplicadaFixtures extends Fixture
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
        return (new TecnicaAplicada())
            ->setNombre($data['nombretecnicaapli']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretecnicaapli' => 'Liofilización',
                ],
                [
                    'nombretecnicaapli' => 'Limpieza con Conservantes',
                ],
                [
                    'nombretecnicaapli' => 'Deshumidificación Intensiva',
                ],
            ];
    }

    public function getOrder()
    {
        return 7;
    }
}