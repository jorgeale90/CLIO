<?php

namespace App\DataFixtures;

use App\Entity\Integridad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IntegridadFixtures extends Fixture
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
        return (new Integridad())
            ->setNombre($data['nombreintegridad']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombreintegridad' => 'Pieza Fragmentada',
                ],
                [
                    'nombreintegridad' => 'Pieza Completa',
                ],
                [
                    'nombreintegridad' => 'Pieza Uniforme',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}