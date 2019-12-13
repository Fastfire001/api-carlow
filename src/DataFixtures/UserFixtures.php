<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstname('firstname')
            ->setLastname('lastname');
        $password = $this->encoder->encodePassword($admin, 'motdepasse95');
        $admin->setPassword($password);


        $manager->persist($admin);

        $manager->flush();
    }
}
