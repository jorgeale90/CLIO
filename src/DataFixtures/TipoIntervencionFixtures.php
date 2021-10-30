<?php

namespace App\DataFixtures;

use App\Entity\TipoIntervencion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoIntervencionFixtures extends Fixture
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
        return (new TipoIntervencion())
            ->setNombre($data['nombretipointer']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipointer' => 'Reparación Capital',
                ],
                [
                    'nombretipointer' => 'Restauración',
                ],
                [
                    'nombretipointer' => 'Restauración Parcial',
                ],
                [
                    'nombretipointer' => 'Acondicionamiento y Limpieza',
                ],
            ];
    }

    public function getOrder()
    {
        return 5;
    }
}