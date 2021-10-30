<?php

namespace App\DataFixtures;

use App\Entity\Estado;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EstadoFixtures extends Fixture
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
        return (new Estado())
            ->setNombre($data['nombreestado']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombreestado' => 'Pendiente de Aprobación',
                ],
                [
                    'nombreestado' => 'En ejecución',
                ],
                [
                    'nombreestado' => 'Completado',
                ],
                [
                    'nombreestado' => 'Cancelado',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}