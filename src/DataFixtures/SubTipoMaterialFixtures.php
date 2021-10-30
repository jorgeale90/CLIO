<?php

namespace App\DataFixtures;

use App\Entity\SubTipoMaterial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubTipoMaterialFixtures extends Fixture
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
        return (new SubTipoMaterial())
            ->setNombre($data['nombresubtipo']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombresubtipo' => 'No definido',
                ],
                [
                    'nombresubtipo' => 'Oro',
                ],
                [
                    'nombresubtipo' => 'Plata',
                ],
                [
                    'nombresubtipo' => 'Bronce',
                ],
                [
                    'nombresubtipo' => 'Cobre',
                ],
                [
                    'nombresubtipo' => 'Hierro',
                ],
                [
                    'nombresubtipo' => 'Plomo',
                ],
                [
                    'nombresubtipo' => 'Acero',
                ],
                [
                    'nombresubtipo' => 'Acero Inoxidable',
                ],
                [
                    'nombresubtipo' => 'Aluminio',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}