<?php

namespace App\DataFixtures;

use App\Entity\CausaIntervencionObjeto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CausaIntervencionObjetoFixtures extends Fixture
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
        return (new CausaIntervencionObjeto())
            ->setNombre($data['nombrecausaintobj']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombrecausaintobj' => 'Restauración Programada',
                ],
                [
                    'nombrecausaintobj' => 'Limpieza Programada',
                ],
                [
                    'nombrecausaintobj' => 'Accidente',
                ],
                [
                    'nombrecausaintobj' => 'Deterioro por uso',
                ],
                [
                    'nombrecausaintobj' => 'Mal estado patrimonial',
                ],
            ];
    }

    public function getOrder()
    {
        return 6;
    }
}