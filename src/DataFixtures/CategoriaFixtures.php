<?php

namespace App\DataFixtures;

use App\Entity\Categoria;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriaFixtures extends Fixture
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
        return (new Categoria())
            ->setNombre($data['nombrecategoria']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecategoria' => 'Patrimonio Natural',
                ],
                [
                    'nombrecategoria' => 'Patrimonio Cultural Material',
                ],
                [
                    'nombrecategoria' => 'Patrimonio Cultural Inmaterial',
                ],
                [
                    'nombrecategoria' => 'Monumento Nacional',
                ],
                [
                    'nombrecategoria' => 'Monumento Provincial',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}