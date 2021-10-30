<?php

namespace App\DataFixtures;

use App\Entity\CausaIntervencion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CausaIntervencionFixtures extends Fixture
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
        return (new CausaIntervencion())
            ->setNombre($data['nombrecausaint']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecausaint' => 'Restauración Programada',
                ],
                [
                    'nombrecausaint' => 'Limpieza Programada',
                ],
                [
                    'nombrecausaint' => 'Accidente',
                ],
                [
                    'nombrecausaint' => 'Deterioro por uso',
                ],
                [
                    'nombrecausaint' => 'Mal estado patrimonial',
                ],
            ];
    }

    public function getOrder()
    {
        return 6;
    }
}