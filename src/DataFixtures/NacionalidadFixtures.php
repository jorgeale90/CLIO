<?php

namespace App\DataFixtures;

use App\Entity\Nacionalidad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NacionalidadFixtures extends Fixture
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
        return (new Nacionalidad())
            ->setNombre($data['nombrenacionalidad']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrenacionalidad' => 'Cubano',
                ],
            ];
    }

    public function getOrder()
    {
        return 8;
    }
}