<?php

namespace App\DataFixtures;

use App\Entity\Contexto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContextoFixtures extends Fixture
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
        return (new Contexto())
            ->setNombre($data['nombrecont']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecont' => 'Terrestre',
                ],
                [
                    'nombrecont' => 'Freatico',
                ],
                [
                    'nombrecont' => 'Subacuatico',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}