<?php

namespace App\DataFixtures;

use App\Entity\Fav;
use App\Entity\Place;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($u = 0; $u < 5; $u++) {
            $user = new User();
            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setEmail($faker->email)
                ->setPassword($hash);

            $manager->persist($user);

            for ($f = 0; $f < mt_rand(1,3); $f++) {
                $fav = new Fav();
                $place = new Place();

                $place->setPlaceId('faker_' . $faker->uuid);

                $fav->setName($faker->streetName)
                    ->setUser($user)
                    ->setPlace($place);

                $manager->persist($fav);
                $manager->persist($place);
            }
        }

        $manager->flush();
    }
}
