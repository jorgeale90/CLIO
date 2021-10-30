<?php

namespace App\DataFixtures;

use App\Entity\Organismo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganismoFixtures extends Fixture
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
        return (new Organismo())
            ->setNombre($data['nombreorgan']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombreorgan' => 'MINTUR',
                ],
                [
                    'nombreorgan' => 'MINREX',
                ],
                [
                    'nombreorgan' => 'MINTRANS',
                ],
                [
                    'nombreorgan' => 'MINSAP',
                ],
            ];
    }

    public function getOrder()
    {
        return 12;
    }
}