<?php

namespace App\DataFixtures;

use App\Entity\Objeto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ObjetoFixtures extends Fixture
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
        return (new Objeto())
            ->setNombre($data['nombreobjeto']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombreobjeto' => 'Cuadro de Lienzo',
                ],
                [
                    'nombreobjeto' => 'Escultura de Madera',
                ],
                [
                    'nombreobjeto' => 'Cuchara',
                ],
                [
                    'nombreobjeto' => 'Libro de Tapa Dura',
                ],
                [
                    'nombreobjeto' => 'Pantalones',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}