<?php

namespace App\Factory;

use App\Entity\Place;
use App\Entity\RideComparison;
use App\Repository\VtcRepository;
use Doctrine\ORM\EntityManagerInterface;

class RideComparisonFactory
{
    /** @var VtcRepository */
    private $vtcRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var RideFactory */
    private $rideFactory;


    public function __construct(
        VtcRepository $vtcRepository,
        EntityManagerInterface $entityManager,
        RideFactory $rideFactory
    )
    {
        $this->vtcRepository = $vtcRepository;
        $this->entityManager = $entityManager;
        $this->rideFactory = $rideFactory;
    }

    public function createRideComparison(array $distanceDuration, Place $startPlace, Place $endPlace): RideComparison
    {

        $rideComparison = new RideComparison();

        $this->entityManager->persist($rideComparison);

        $maxPrice = 0;
        foreach ($this->vtcRepository->findAll() as $vtc) {
            $ride = $this->rideFactory->createRide($vtc, $distanceDuration, $startPlace, $endPlace);

            if ($maxPrice < $ride->getPrice()) {
                $maxPrice = $ride->getPrice();
            }

            $rideComparison->addRide($ride);

            $this->entityManager->persist($ride);
        }

        $rideComparison->setMaxPrice($maxPrice)
            ->setDistance($distanceDuration['distance'])
            ->setDuration($distanceDuration['duration']);

        $this->entityManager->flush();

        return $rideComparison;
    }
}