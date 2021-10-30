<?php

namespace App\DataFixtures;

use App\Entity\Datacion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DatacionFixtures extends Fixture
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
        return (new Datacion())
            ->setNombre($data['nombredatacion']);
    }

    private function getData()
    {
        return
            [
                [
                    'nombredatacion' => 'Era Antigua',
                ],
                [
                    'nombredatacion' => 'Siglos I - VI D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos VI - X D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos X - XV D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos XV D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos XVI D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos XVII D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos XVIII D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos XIX D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos XX D.C.',
                ],
                [
                    'nombredatacion' => 'Siglos XXI D.C.',
                ],
            ];
    }

    public function getOrder()
    {
        return 3;
    }
}