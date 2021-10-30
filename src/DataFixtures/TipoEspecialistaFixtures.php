<?php

namespace App\DataFixtures;

use App\Entity\TipoEspecialista;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoEspecialistaFixtures extends Fixture
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
        return (new TipoEspecialista())
            ->setNombre($data['nombretipoesp']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipoesp' => 'Investigador',
                ],
                [
                    'nombretipoesp' => 'Tecnico',
                ],
                [
                    'nombretipoesp' => 'Personal Apoyo',
                ],
            ];
    }

    public function getOrder()
    {
        return 9;
    }
}