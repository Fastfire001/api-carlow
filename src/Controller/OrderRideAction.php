<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderRideAction extends AbstractController
{

    /** @var RideRepository */
    private $rideRepository;

    public function __construct(RideRepository $rideRepository)
    {
        $this->rideRepository = $rideRepository;
    }

    public function __invoke(Request $request): Response
    {
        if (!$request->query->has('rideId')) {
            return $this->json('missing rideId in query', 400);
        }

        $ride = $this->rideRepository->find($request->query->get('rideId'));

        if ($ride === null) {
            return $this->json('ride not found', 404);
        }

        /** @var User $user */
        $user = $this->getUser();
        if ($this->getUser() !== $user) {
            return $this->json('bad user', 400);
        }

        if ($ride->getIsOrdered()) {
            return $this->json('Ride already ordered', 400);
        }

        $savedPrice = $ride->getRideComparison()->getMaxPrice() - $ride->getPrice();
        $user->setSavingPrice($user->getSavingPrice() + $savedPrice);
        $ride->setIsOrdered(true);

        $this->getDoctrine()->getManager()->flush();

        return $this->json('ok');
    }
}