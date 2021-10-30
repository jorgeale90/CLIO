<?php

namespace App\DataFixtures;

use App\Entity\TratamientoLaboratorio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TratamientoLaboratorioFixtures extends Fixture
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
        return (new TratamientoLaboratorio())
            ->setNombre($data['nombretratamlab']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretratamlab' => 'Liofilización',
                ],
                [
                    'nombretratamlab' => 'Limpieza con Conservantes',
                ],
                [
                    'nombretratamlab' => 'Deshumidificación Intensiva',
                ],
            ];
    }

    public function getOrder()
    {
        return 7;
    }
}