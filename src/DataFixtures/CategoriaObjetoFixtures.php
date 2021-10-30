<?php

namespace App\DataFixtures;

use App\Entity\CategoriaObjeto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriaObjetoFixtures extends Fixture
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
        return (new CategoriaObjeto())
            ->setNombre($data['nombrecategoriaobj']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecategoriaobj' => 'Obra de Arte',
                ],
                [
                    'nombrecategoriaobj' => 'Vajilla',
                ],
                [
                    'nombrecategoriaobj' => 'Libros',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}