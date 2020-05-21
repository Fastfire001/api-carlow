<?php

namespace App\DataFixtures;

use App\Entity\Fav;
use App\Entity\Option;
use App\Entity\Place;
use App\Entity\User;
use App\Entity\Vtc;
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
                ->setPassword($hash)
                ->setSavingPrice(mt_rand(0, 1000));

            $manager->persist($user);

            for ($f = 0; $f < mt_rand(1,3); $f++) {
                $fav = new Fav();
                $place = new Place();

                $place->setGooglePlaceId('faker_' . $faker->uuid);

                $fav->setName($faker->streetName)
                    ->setUser($user)
                    ->setPlace($place);

                $manager->persist($fav);
                $manager->persist($place);
            }
        }

        $vtcDatas = [
            [
                'name' => 'Allocab',
                'slug' => 'allocab',
                'indemnification' => 160,
                'pricePerKilometer' => 115,
                'pricePerMinute' => 35,
            ],
            [
                'name' => 'Kapten',
                'slug' => 'kapten',
                'indemnification' => 110,
                'pricePerKilometer' => 110,
                'pricePerMinute' => 28,
            ],
            [
                'name' => 'Heetch',
                'slug' => 'heetch',
                'indemnification' => 150,
                'pricePerKilometer' => 100,
                'pricePerMinute' => 15,
            ],
            [
                'name' => 'Marcel',
                'slug' => 'marcel',
                'indemnification' => 150,
                'pricePerKilometer' => 110,
                'pricePerMinute' => 32,
            ],
            [
                'name' => 'Uber',
                'slug' => 'uber',
                'indemnification' => 120,
                'pricePerKilometer' => 105,
                'pricePerMinute' => 30,
            ],
        ];
        foreach ($vtcDatas as $data) {
            $vtc = new Vtc();
            $vtc->setName($data['name'])
                ->setSlug($data['slug'])
                ->setIndemnification($data['indemnification'])
                ->setPricePerKilometer($data['pricePerKilometer'])
                ->setPricePerMinute($data['pricePerMinute']);

            $manager->persist($vtc);
        }

        $optionsDatas = [
            'green',
            'berline',
            'van',
        ];

        foreach ($optionsDatas as $data) {
            $option = new Option();
            $option->setSlug($data);

            $manager->persist($option);
        }


        $manager->flush();
    }
}
