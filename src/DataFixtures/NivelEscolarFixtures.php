<?php

namespace App\DataFixtures;

use App\Entity\NivelEscolar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NivelEscolarFixtures extends Fixture
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
        return (new NivelEscolar())
            ->setNombre($data['nombrenivelescolar']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrenivelescolar' => 'Primario',
                ],
                [
                    'nombrenivelescolar' => 'Secundario',
                ],
                [
                    'nombrenivelescolar' => 'Bachiller',
                ],
                [
                    'nombrenivelescolar' => 'Tecnico Medio',
                ],
                [
                    'nombrenivelescolar' => 'Universitario',
                ],
            ];
    }

    public function getOrder()
    {
        return 7;
    }
}