<?php

namespace App\DataFixtures;

use App\Entity\TipoIntervencionObjeto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoIntervencionObjetoFixtures extends Fixture
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
        return (new TipoIntervencionObjeto())
            ->setNombre($data['nombretipointerobj']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipointerobj' => 'Conservación',
                ],
                [
                    'nombretipointerobj' => 'Restauración',
                ],
                [
                    'nombretipointerobj' => 'Restauración Parcial',
                ],
                [
                    'nombretipointerobj' => 'Acondicionamiento y Limpieza',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}