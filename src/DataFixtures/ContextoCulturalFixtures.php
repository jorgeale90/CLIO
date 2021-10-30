<?php

namespace App\DataFixtures;

use App\Entity\ContextoCultural;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContextoCulturalFixtures extends Fixture
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
        return (new ContextoCultural())
            ->setNombre($data['nombrecontextocult']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecontextocult' => 'Terrestre',
                ],
                [
                    'nombrecontextocult' => 'Freatico',
                ],
                [
                    'nombrecontextocult' => 'Subacuatico',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}