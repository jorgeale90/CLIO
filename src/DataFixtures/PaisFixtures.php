<?php

namespace App\DataFixtures;

use App\Entity\Pais;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaisFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $country = $this->getPais($data);
            //addReference() me ayudara hacerle referencia al ProvinciaFixture.php o sea la relación Pais-Provincia
            $this->addReference($data['reference'], $country);

            $manager->persist($country);
        }

        $manager->flush();
    }

    private function getPais(array $data)
    {
        return (new Pais())
            ->setNombre($data['nombrepais']);
    }

    private function getData()
    {
        return
            [
                [
                    'reference' => 'afga',
                    'nombrepais' => 'Afganistán',
                ],
                [
                    'reference' => 'albania',
                    'nombrepais' => 'Albania',
                ],
                [
                    'reference' => 'alem',
                    'nombrepais' => 'Alemania',
                ],
                [
                    'reference' => 'ando',
                    'nombrepais' => 'Andorra',
                ],
                [
                    'reference' => 'ango',
                    'nombrepais' => 'Angola',
                ],
                [
                    'reference' => 'anti',
                    'nombrepais' => 'Antigua y Barbuda',
                ],
                [
                    'reference' => 'ara',
                    'nombrepais' => 'Arabia Saudita',
                ],
                [
                    'reference' => 'arge',
                    'nombrepais' => 'Argelia',
                ],
                [
                    'reference' => 'argentina',
                    'nombrepais' => 'Argentina',
                ],
                [
                    'reference' => 'armen',
                    'nombrepais' => 'Armenia',
                ],
                [
                    'reference' => 'austra',
                    'nombrepais' => 'Australia',
                ],
                [
                    'reference' => 'austr',
                    'nombrepais' => 'Austria',
                ],
                [
                    'reference' => 'azerb',
                    'nombrepais' => 'Azerbaiyán',
                ],
                [
                    'reference' => 'baha',
                    'nombrepais' => 'Bahamas',
                ],
                [
                    'reference' => 'bang',
                    'nombrepais' => 'Bangladés',
                ],
                [
                    'reference' => 'barb',
                    'nombrepais' => 'Barbados',
                ],
                [
                    'reference' => 'bare',
                    'nombrepais' => 'Baréin',
                ],
                [
                    'reference' => 'belg',
                    'nombrepais' => 'Bélgica',
                ],
                [
                    'reference' => 'belic',
                    'nombrepais' => 'Belice',
                ],
                [
                    'reference' => 'ben',
                    'nombrepais' => 'Benín',
                ],
                [
                    'reference' => 'bielor',
                    'nombrepais' => 'Bielorrusia',
                ],
                [
                    'reference' => 'birman',
                    'nombrepais' => 'Birmania/Myanmar',
                ],
                [
                    'reference' => 'bolivi',
                    'nombrepais' => 'Bolivia',
                ],
                [
                    'reference' => 'bosnia',
                    'nombrepais' => 'Bosnia y Herzegovina',
                ],
                [
                    'reference' => 'botsua',
                    'nombrepais' => 'Botsuana',
                ],
                [
                    'reference' => 'brasil',
                    'nombrepais' => 'Brasil',
                ],
                [
                    'reference' => 'brunei',
                    'nombrepais' => 'Brunéi',
                ],
                [
                    'reference' => 'bulgaria',
                    'nombrepais' => 'Bulgaria',
                ],
                [
                    'reference' => 'burkin',
                    'nombrepais' => 'Burkina Faso',
                ],
                [
                    'reference' => 'burundi',
                    'nombrepais' => 'Burundi',
                ],
                [
                    'reference' => 'butan',
                    'nombrepais' => 'Bután',
                ],
                [
                    'reference' => 'cabo',
                    'nombrepais' => 'Cabo Verde',
                ],
                [
                    'reference' => 'camboy',
                    'nombrepais' => 'Camboya',
                ],
                [
                    'reference' => 'camerun',
                    'nombrepais' => 'Camerún',
                ],
                [
                    'reference' => 'canada',
                    'nombrepais' => 'Canadá',
                ],
                [
                    'reference' => 'qatar',
                    'nombrepais' => 'Catar',
                ],
                [
                    'reference' => 'chad',
                    'nombrepais' => 'Chad',
                ],
                [
                    'reference' => 'chile',
                    'nombrepais' => 'Chile',
                ],
                [
                    'reference' => 'china',
                    'nombrepais' => 'China',
                ],
                [
                    'reference' => 'chipre',
                    'nombrepais' => 'Chipre',
                ],
                [
                    'reference' => 'vaticano',
                    'nombrepais' => 'Ciudad del Vaticano',
                ],
                [
                    'reference' => 'colom',
                    'nombrepais' => 'Colombia',
                ],
                [
                    'reference' => 'comoras',
                    'nombrepais' => 'Comoras',
                ],
                [
                    'reference' => 'corean',
                    'nombrepais' => 'Corea del Norte',
                ],
                [
                    'reference' => 'coreas',
                    'nombrepais' => 'Corea del Sur',
                ],
                [
                    'reference' => 'costamar',
                    'nombrepais' => 'Costa de Marfil',
                ],
                [
                    'reference' => 'costarica',
                    'nombrepais' => 'Costa Rica',
                ],
                [
                    'reference' => 'croacia',
                    'nombrepais' => 'Croacia',
                ],
                [
                    'reference' => 'cuba',
                    'nombrepais' => 'Cuba',
                ],
                [
                    'reference' => 'dinama',
                    'nombrepais' => 'Dinamarca',
                ],
                [
                    'reference' => 'domini',
                    'nombrepais' => 'Dominica',
                ],
                [
                    'reference' => 'ecuad',
                    'nombrepais' => 'Ecuador',
                ],
                [
                    'reference' => 'egip',
                    'nombrepais' => 'Egipto',
                ],
                [
                    'reference' => 'salvad',
                    'nombrepais' => 'El Salvador',
                ],
                [
                    'reference' => 'emiratos',
                    'nombrepais' => 'Emiratos Árabes Unidos',
                ],
                [
                    'reference' => 'eritrea',
                    'nombrepais' => 'Eritrea',
                ],
                [
                    'reference' => 'eslov',
                    'nombrepais' => 'Eslovaquia',
                ],
                [
                    'reference' => 'eslovenia',
                    'nombrepais' => 'Eslovenia',
                ],
                [
                    'reference' => 'espana',
                    'nombrepais' => 'España',
                ],
                [
                    'reference' => 'estadosu',
                    'nombrepais' => 'Estados Unidos',
                ],
                [
                    'reference' => 'estonia',
                    'nombrepais' => 'Estonia',
                ],
                [
                    'reference' => 'etiopia',
                    'nombrepais' => 'Etiopía',
                ],
                [
                    'reference' => 'filipinas',
                    'nombrepais' => 'Filipinas',
                ],
                [
                    'reference' => 'finland',
                    'nombrepais' => 'Finlandia',
                ],
                [
                    'reference' => 'fiyi',
                    'nombrepais' => 'Fiyi',
                ],
                [
                    'reference' => 'francia',
                    'nombrepais' => 'Francia',
                ],
                [
                    'reference' => 'gabon',
                    'nombrepais' => 'Gabón',
                ],
                [
                    'reference' => 'gambia',
                    'nombrepais' => 'Gambia',
                ],
                [
                    'reference' => 'georgia',
                    'nombrepais' => 'Georgia',
                ],
                [
                    'reference' => 'ghana',
                    'nombrepais' => 'Ghana',
                ],
                [
                    'reference' => 'granada',
                    'nombrepais' => 'Granada',
                ],
                [
                    'reference' => 'grecia',
                    'nombrepais' => 'Grecia',
                ],
                [
                    'reference' => 'guatemala',
                    'nombrepais' => 'Guatemala',
                ],
                [
                    'reference' => 'guyana',
                    'nombrepais' => 'Guyana',
                ],
                [
                    'reference' => 'guinea',
                    'nombrepais' => 'Guinea',
                ],
                [
                    'reference' => 'guineaecua',
                    'nombrepais' => 'Guinea ecuatorial',
                ],
                [
                    'reference' => 'guineabis',
                    'nombrepais' => 'Guinea-Bisáu',
                ],
                [
                    'reference' => 'haiti',
                    'nombrepais' => 'Haití',
                ],
                [
                    'reference' => 'hondura',
                    'nombrepais' => 'Honduras',
                ],
                [
                    'reference' => 'hungria',
                    'nombrepais' => 'Hungría',
                ],
                [
                    'reference' => 'india',
                    'nombrepais' => 'India',
                ],
                [
                    'reference' => 'indonesia',
                    'nombrepais' => 'Indonesia',
                ],
                [
                    'reference' => 'iran',
                    'nombrepais' => 'Irán',
                ],
                [
                    'reference' => 'irlanda',
                    'nombrepais' => 'Irlanda',
                ],
                [
                    'reference' => 'islndia',
                    'nombrepais' => 'Islandia',
                ],
                [
                    'reference' => 'marshall',
                    'nombrepais' => 'Islas Marshall',
                ],
                [
                    'reference' => 'salomon',
                    'nombrepais' => 'Islas Salomón',
                ],
                [
                    'reference' => 'israel',
                    'nombrepais' => 'Israel',
                ],
                [
                    'reference' => 'italia',
                    'nombrepais' => 'Italia',
                ],
                [
                    'reference' => 'jamaica',
                    'nombrepais' => 'Jamaica',
                ],
                [
                    'reference' => 'japon',
                    'nombrepais' => 'Japón',
                ],
                [
                    'reference' => 'jordania',
                    'nombrepais' => 'Jordania',
                ],
                [
                    'reference' => 'kazajas',
                    'nombrepais' => 'Kazajistán',
                ],
                [
                    'reference' => 'kenia',
                    'nombrepais' => 'Kenia',
                ],
                [
                    'reference' => 'kirguis',
                    'nombrepais' => 'Kirguistán',
                ],
                [
                    'reference' => 'kiribati',
                    'nombrepais' => 'Kiribati',
                ],
                [
                    'reference' => 'kuwait',
                    'nombrepais' => 'Kuwait',
                ],
                [
                    'reference' => 'laos',
                    'nombrepais' => 'Laos',
                ],
                [
                    'reference' => 'lesoto',
                    'nombrepais' => 'Lesoto',
                ],
                [
                    'reference' => 'letonia',
                    'nombrepais' => 'Letonia',
                ],
                [
                    'reference' => 'libano',
                    'nombrepais' => 'Líbano',
                ],
                [
                    'reference' => 'liberia',
                    'nombrepais' => 'Liberia',
                ],
                [
                    'reference' => 'libia',
                    'nombrepais' => 'Libia',
                ],
                [
                    'reference' => 'liecht',
                    'nombrepais' => 'Liechtenstein',
                ],
                [
                    'reference' => 'lituania',
                    'nombrepais' => 'Lituania',
                ],
                [
                    'reference' => 'Luxemburgo',
                    'nombrepais' => 'luxem',
                ],
                [
                    'reference' => 'macedonia',
                    'nombrepais' => 'Macedonia del Norte',
                ],
                [
                    'reference' => 'madagascar',
                    'nombrepais' => 'Madagascar',
                ],
                [
                    'reference' => 'malasia',
                    'nombrepais' => 'Malasia',
                ],
                [
                    'reference' => 'malaui',
                    'nombrepais' => 'Malaui',
                ],
                [
                    'reference' => 'maldivas',
                    'nombrepais' => 'Maldivas',
                ],
                [
                    'reference' => 'mali',
                    'nombrepais' => 'Malí',
                ],
                [
                    'reference' => 'malta',
                    'nombrepais' => 'Malta',
                ],
                [
                    'reference' => 'marruecos',
                    'nombrepais' => 'Marruecos',
                ],
                [
                    'reference' => 'mauricio',
                    'nombrepais' => 'Mauricio',
                ],
                [
                    'reference' => 'mauritania',
                    'nombrepais' => 'Mauritania',
                ],
                [
                    'reference' => 'mexico',
                    'nombrepais' => 'México',
                ],
                [
                    'reference' => 'micronesia',
                    'nombrepais' => 'Micronesia',
                ],
                [
                    'reference' => 'moldavia',
                    'nombrepais' => 'Moldavia',
                ],
                [
                    'reference' => 'monaco',
                    'nombrepais' => 'Mónaco',
                ],
                [
                    'reference' => 'mongolia',
                    'nombrepais' => 'Mongolia',
                ],
                [
                    'reference' => 'montenegro',
                    'nombrepais' => 'Montenegro',
                ],
                [
                    'reference' => 'mozam',
                    'nombrepais' => 'Mozambique',
                ],
                [
                    'reference' => 'namibia',
                    'nombrepais' => 'Namibia',
                ],
                [
                    'reference' => 'nauru',
                    'nombrepais' => 'Nauru',
                ],
                [
                    'reference' => 'nepal',
                    'nombrepais' => 'Nepal',
                ],
                [
                    'reference' => 'nicaragua',
                    'nombrepais' => 'Nicaragua',
                ],
                [
                    'reference' => 'niger',
                    'nombrepais' => 'Níger',
                ],
                [
                    'reference' => 'nigeria',
                    'nombrepais' => 'Nigeria',
                ],
                [
                    'reference' => 'noregua',
                    'nombrepais' => 'Noruega',
                ],
                [
                    'reference' => 'nuevaze',
                    'nombrepais' => 'Nueva Zelanda',
                ],
                [
                    'reference' => 'oman',
                    'nombrepais' => 'Omán',
                ],
                [
                    'reference' => 'paisesba',
                    'nombrepais' => 'Países Bajos',
                ],
                [
                    'reference' => 'pakistan',
                    'nombrepais' => 'Pakistán',
                ],
                [
                    'reference' => 'palaos',
                    'nombrepais' => 'Palaos',
                ],
                [
                    'reference' => 'panama',
                    'nombrepais' => 'Panamá',
                ],
                [
                    'reference' => 'papuan',
                    'nombrepais' => 'Papúa Nueva Guinea',
                ],
                [
                    'reference' => 'paraguay',
                    'nombrepais' => 'Paraguay',
                ],
                [
                    'reference' => 'peru',
                    'nombrepais' => 'Perú',
                ],
                [
                    'reference' => 'polonia',
                    'nombrepais' => 'Polonia',
                ],
                [
                    'reference' => 'portugal',
                    'nombrepais' => 'Portugal',
                ],
                [
                    'reference' => 'reinounido',
                    'nombrepais' => 'Reino Unido',
                ],
                [
                    'reference' => 'centroafrica',
                    'nombrepais' => 'República Centroafricana',
                ],
                [
                    'reference' => 'checa',
                    'nombrepais' => 'República Checa',
                ],
                [
                    'reference' => 'rcongo',
                    'nombrepais' => 'República del Congo',
                ],
                [
                    'reference' => 'rdcongo',
                    'nombrepais' => 'República Democrática del Congo',
                ],
                [
                    'reference' => 'dominicana',
                    'nombrepais' => 'República Dominicana',
                ],
                [
                    'reference' => 'sudafrica',
                    'nombrepais' => 'República Sudafricana',
                ],
                [
                    'reference' => 'ruanda',
                    'nombrepais' => 'Ruanda',
                ],
                [
                    'reference' => 'rumania',
                    'nombrepais' => 'Rumanía',
                ],
                [
                    'reference' => 'rusia',
                    'nombrepais' => 'Rusia',
                ],
                [
                    'reference' => 'samoa',
                    'nombrepais' => 'Samoa',
                ],
                [
                    'reference' => 'scristobal',
                    'nombrepais' => 'San Cristóbal y Nieves',
                ],
                [
                    'reference' => 'marinos',
                    'nombrepais' => 'San Marino',
                ],
                [
                    'reference' => 'svicente',
                    'nombrepais' => 'San Vicente y las Granadinas',
                ],
                [
                    'reference' => 'santalu',
                    'nombrepais' => 'Santa Lucía',
                ],
                [
                    'reference' => 'santotome',
                    'nombrepais' => 'Santo Tomé y Príncipe',
                ],
                [
                    'reference' => 'senegal',
                    'nombrepais' => 'Senegal',
                ],
                [
                    'reference' => 'serbia',
                    'nombrepais' => 'Serbia',
                ],
                [
                    'reference' => 'seyche',
                    'nombrepais' => 'Seychelles',
                ],
                [
                    'reference' => 'sierral',
                    'nombrepais' => 'Sierra Leona',
                ],
                [
                    'reference' => 'singap',
                    'nombrepais' => 'Singapur',
                ],
                [
                    'reference' => 'siria',
                    'nombrepais' => 'Siria',
                ],
                [
                    'reference' => 'somalia',
                    'nombrepais' => 'Somalia',
                ],
                [
                    'reference' => 'lanka',
                    'nombrepais' => 'Sri Lanka',
                ],
                [
                    'reference' => 'suazi',
                    'nombrepais' => 'Suazilandia',
                ],
                [
                    'reference' => 'sudan',
                    'nombrepais' => 'Sudán',
                ],
                [
                    'reference' => 'sudans',
                    'nombrepais' => 'Sudán del Sur',
                ],
                [
                    'reference' => 'suecia',
                    'nombrepais' => 'Suecia',
                ],
                [
                    'reference' => 'suiza',
                    'nombrepais' => 'Suiza',
                ],
                [
                    'reference' => 'surinam',
                    'nombrepais' => 'Surinam',
                ],
                [
                    'reference' => 'tailandia',
                    'nombrepais' => 'Tailandia',
                ],
                [
                    'reference' => 'tanzania',
                    'nombrepais' => 'Tanzania',
                ],
                [
                    'reference' => 'tayis',
                    'nombrepais' => 'Tayikistán',
                ],
                [
                    'reference' => 'timoro',
                    'nombrepais' => 'Timor Oriental',
                ],
                [
                    'reference' => 'togo',
                    'nombrepais' => 'Togo',
                ],
                [
                    'reference' => 'tonga',
                    'nombrepais' => 'Tonga',
                ],
                [
                    'reference' => 'trinidad',
                    'nombrepais' => 'Trinidad y Tobago',
                ],
                [
                    'reference' => 'tunez',
                    'nombrepais' => 'Túnez',
                ],
                [
                    'reference' => 'turkm',
                    'nombrepais' => 'Turkmenistán',
                ],
                [
                    'reference' => 'turkia',
                    'nombrepais' => 'Turquía',
                ],
                [
                    'reference' => 'tuvalu',
                    'nombrepais' => 'Tuvalu',
                ],
                [
                    'reference' => 'ucrania',
                    'nombrepais' => 'Ucrania',
                ],
                [
                    'reference' => 'uganda',
                    'nombrepais' => 'Uganda',
                ],
                [
                    'reference' => 'uruguay',
                    'nombrepais' => 'Uruguay',
                ],
                [
                    'reference' => 'uzbeki',
                    'nombrepais' => 'Uzbekistán',
                ],
                [
                    'reference' => 'vanuatu',
                    'nombrepais' => 'Vanuatu',
                ],
                [
                    'reference' => 'venezuela',
                    'nombrepais' => 'Venezuela',
                ],
                [
                    'reference' => 'vietnam',
                    'nombrepais' => 'Vietnam',
                ],
                [
                    'reference' => 'yemen',
                    'nombrepais' => 'Yemen',
                ],
                [
                    'reference' => 'yibuti',
                    'nombrepais' => 'Yibuti',
                ],
                [
                    'reference' => 'zambia',
                    'nombrepais' => 'Zambia',
                ],
                [
                    'reference' => 'zimbabue',
                    'nombrepais' => 'Zimbabue',
                ],
            ];
    }

    public function getOrder()
    {
        return 1;
    }
}