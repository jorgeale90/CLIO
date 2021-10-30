<?php

namespace App\DataFixtures;

use App\Entity\UsoFuncion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsoFuncionFixtures extends Fixture
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
        return (new UsoFuncion())
            ->setNombre($data['nombreusofuncion']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombreusofuncion' => 'No Definido',
                ],
                [
                    'nombreusofuncion' => 'Arquitectura Naval',
                ],
                [
                    'nombreusofuncion' => 'Utencilio Marineria',
                ],
                [
                    'nombreusofuncion' => 'Parte de Armamento',
                ],
                [
                    'nombreusofuncion' => 'Arboladura',
                ],
                [
                    'nombreusofuncion' => 'Armamento',
                ],
                [
                    'nombreusofuncion' => 'Maquinaria',
                ],
                [
                    'nombreusofuncion' => 'Proviciones',
                ],
            ];
    }

    public function getOrder()
    {
        return 8;
    }
}