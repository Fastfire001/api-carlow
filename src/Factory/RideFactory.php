<?php

namespace App\Factory;

use App\Entity\Option;
use App\Entity\Place;
use App\Entity\Ride;
use App\Entity\Vtc;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class RideFactory
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Security */
    private $security;

    /** @var OptionRepository */
    private $optionRepository;
    /** @var Option|null */
    private $berlineOption;
    /** @var Option|null */
    private $vanOption;
    /** @var Option|null */
    private $greenOption;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        OptionRepository $optionRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->optionRepository = $optionRepository;
        $this->berlineOption = $this->optionRepository->findOneBy(['Slug' => 'berline']);
        $this->vanOption = $this->optionRepository->findOneBy(['Slug' => 'van']);
        $this->greenOption = $this->optionRepository->findOneBy(['Slug' => 'green']);
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

        $emission = mt_rand(160, 190);
        $ride->setUser($user)
            ->setStartPosition($startPlace)
            ->setEndPosition($endPlace)
            ->setPrice($price)
            ->setTimeBeforeDeparture(mt_rand(2, 10))
            ->setVtc($vtc)
            ->setEmission($emission * ($distanceDuration['distance'] / 1000));

        $rand = mt_rand(1, 3);

        if ($rand === 1) {
            $ride->addOption($this->berlineOption);
        } elseif ($rand ===2) {
            $ride->addOption($this->vanOption);
        } else {
            $ride->addOption($this->vanOption)
                ->addOption($this->berlineOption);
        }

        if ($emission < 175) {
            $ride->addOption($this->greenOption);
        }

        return $ride;
    }
}