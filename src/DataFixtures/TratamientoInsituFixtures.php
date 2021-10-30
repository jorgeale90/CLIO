<?php

namespace App\DataFixtures;

use App\Entity\TratamientoInsitu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TratamientoInsituFixtures extends Fixture
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
        return (new TratamientoInsitu())
            ->setNombre($data['nombretrataminsi']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretrataminsi' => 'Limpieza',
                ],
                [
                    'nombretrataminsi' => 'Aspiración',
                ],
                [
                    'nombretrataminsi' => 'Deshumidificación',
                ],
            ];
    }

    public function getOrder()
    {
        return 7;
    }
}