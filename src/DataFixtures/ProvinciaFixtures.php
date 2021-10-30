<?php

namespace App\DataFixtures;

use App\Entity\Provincia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProvinciaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $entity = $this->getProvincia($data);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function getProvincia(array $data)
    {
        return (new Provincia())
            ->setNombre($data['nombre'])
            //getReference es la función que me ayudara a relacionar los Paises con sus Provincias.
            ->setPais($this->getReference($data['pais']));
    }

    private function getData()
    {
        return
            [
                [
                    'nombre' => 'Santiago de Cuba',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Granma',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Guantánamo',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Holguín',
                    'pais' => 'cuba',
                ],
                [
                    'reference' => 'tunas',
                    'nombre' => 'Las Tunas',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Camagüey',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Ciego de Ávila',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Sancti Spíritus',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Villa Clara',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Cienfuegos',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Matanzas',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Mayabeque',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'La Habana',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Artemisa',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Pinar del Río',
                    'pais' => 'cuba',
                ],
                [
                    'nombre' => 'Municipio Especial Isla de la Juventud',
                    'pais' => 'cuba',
                ],
            ];
    }

    public function getOrder()
    {
        return 2;
    }
}