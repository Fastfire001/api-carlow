<?php

namespace App\Factory;

use App\Entity\Place;
use App\Entity\Ride;
use App\Entity\Vtc;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class RideFactory
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Security */
    private $security;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function createRide(Vtc $vtc, array $distanceDuration, Place $startPlace, Place $endPlace): Ride
    {
        if (!($user = $this->security->getUser()) instanceof UserInterface) {
            throw new \Exception('Must be logged in');
        }

        $price = $vtc->getIndemnification();
        $price += $vtc->getPricePerKilometer() * ($distanceDuration['distance'] / 1000);
        $price += $vtc->getPricePerMinute() * ($distanceDuration['duration'] / 60);

        $ride = new Ride();

        $ride->setUser($user)
            ->setStartPosition($startPlace)
            ->setEndPosition($endPlace)
            ->setPrice($price)
            ->setTimeBeforeDeparture(mt_rand(2, 10))
            ->setVtc($vtc);

        return $ride;
    }
}