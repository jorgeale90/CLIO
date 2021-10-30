<?php

namespace App\DataFixtures;

use App\Entity\TipoObjeto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoObjetoFixtures extends Fixture
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
        return (new TipoObjeto())
            ->setNombre($data['nombretipoobjeto']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipoobjeto' => 'Pintura',
                ],
                [
                    'nombretipoobjeto' => 'Escultura',
                ],
                [
                    'nombretipoobjeto' => 'Cubiertos',
                ],
                [
                    'nombretipoobjeto' => 'Libro',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}