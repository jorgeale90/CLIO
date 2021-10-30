<?php

namespace App\DataFixtures;

use App\Entity\TipoMaterial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoMaterialFixtures extends Fixture
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
        return (new TipoMaterial())
            ->setNombre($data['nombretipomaterial']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipomaterial' => 'No definido',
                ],
                [
                    'nombretipomaterial' => 'Metal',
                ],
                [
                    'nombretipomaterial' => 'Cristal',
                ],
                [
                    'nombretipomaterial' => 'Madera',
                ],
                [
                    'nombretipomaterial' => 'Ceramica',
                ],
                [
                    'nombretipomaterial' => 'Porcelana',
                ],
                [
                    'nombretipomaterial' => 'Piedra',
                ],
                [
                    'nombretipomaterial' => 'Plastico',
                ],
                [
                    'nombretipomaterial' => 'Textil',
                ],
                [
                    'nombretipomaterial' => 'Mixto',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}