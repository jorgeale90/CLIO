<?php

namespace App\DataFixtures;

use App\Entity\CategoriaCientifica;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriaCientificaFixtures extends Fixture
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
        return (new CategoriaCientifica())
            ->setNombre($data['nombrecategoriacient']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecategoriacient' => 'Ms. C.',
                ],
                [
                    'nombrecategoriacient' => 'Dr. C.',
                ],
                [
                    'nombrecategoriacient' => 'Dr. Cs.',
                ],
            ];
    }

    public function getOrder()
    {
        return 11;
    }
}