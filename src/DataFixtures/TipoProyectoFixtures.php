<?php

namespace App\DataFixtures;

use App\Entity\TipoProyecto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TipoProyectoFixtures extends Fixture
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
        return (new TipoProyecto())
            ->setNombre($data['nombretipoproyecto']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombretipoproyecto' => 'Investigación Documental',
                ],
                [
                    'nombretipoproyecto' => 'Investigación Historica',
                ],
                [
                    'nombretipoproyecto' => 'Intervención Arqueológica',
                ],
                [
                    'nombretipoproyecto' => 'Intervención de Conservación',
                ],
                [
                    'nombretipoproyecto' => 'Intervención Objeto Patrimonial',
                ],
            ];
    }

    public function getOrder()
    {
        return 4;
    }
}