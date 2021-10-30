<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('patrimoniocuba@gmail.com');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setFirstname('Jesus');
        $user->setLastname('Vicente Gonzalez');
        $user->setStatus('1');
        $user->setIsadmin('1');

        $password = $this->encoder->encodePassword($user, 'Patrimonio123');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}