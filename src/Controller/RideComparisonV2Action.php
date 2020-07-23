<?php

namespace App\Controller;

use App\Factory\RideComparisonFactory;
use App\Repository\PlaceRepository;
use App\Serializer\RideComparisonNormalizer;
use App\Services\GoogleDistanceMatrixApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RideComparisonV2Action extends AbstractController
{
    /** @var PlaceRepository */
    private $placeRepository;

    /** @var GoogleDistanceMatrixApiService */
    private $googleDistanceMatrixApiService;

    /** @var RideComparisonFactory */
    private $rideComparisonFactory;

    /** @var RideComparisonNormalizer */
    private $rideComparisonNormalizer;

    public function __construct(
        PlaceRepository $placeRepository,
        GoogleDistanceMatrixApiService $googleDistanceMatrixApiService,
        RideComparisonFactory $rideComparisonFactory,
        RideComparisonNormalizer $rideComparisonNormalizer
    )
    {
        $this->placeRepository = $placeRepository;
        $this->googleDistanceMatrixApiService = $googleDistanceMatrixApiService;
        $this->rideComparisonFactory = $rideComparisonFactory;
        $this->rideComparisonNormalizer = $rideComparisonNormalizer;
    }

    public function __invoke(Request $request): Response
    {
        if ($request->query->has('start_place_id')) {
            $startPlace = $this->placeRepository->find($request->query->get('start_place_id'));
        }

        if ($request->query->has('end_place_id')) {
            $endPlace = $this->placeRepository->find($request->query->get('end_place_id'));
        }

        if (!isset($startPlace)) {
            return $this->json(['error' => 'start_place_id is required in query'], 400);
        }
        if (!isset($endPlace)) {
            return $this->json(['error' => 'end_place_id is required in query'], 400);
        }

        $distanceDuration = $this->googleDistanceMatrixApiService->getDistanceAndDuration($startPlace, $endPlace);
        $rideComparison = $this->rideComparisonFactory->createRideComparison($distanceDuration, $startPlace, $endPlace);

        $data = $this->rideComparisonNormalizer->normalize($rideComparison, 'json');

        return $this->json($data);
    }
}