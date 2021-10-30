<?php

namespace App\DataFixtures;

use App\Entity\CategoriaDocente;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriaDocenteFixtures extends Fixture
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
        return (new CategoriaDocente())
            ->setNombre($data['nombrecategoriadoc']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecategoriadoc' => 'Instructor',
                ],
                [
                    'nombrecategoriadoc' => 'Asistente',
                ],
                [
                    'nombrecategoriadoc' => 'Auxiliar',
                ],
                [
                    'nombrecategoriadoc' => 'Titular',
                ],
            ];
    }

    public function getOrder()
    {
        return 10;
    }
}