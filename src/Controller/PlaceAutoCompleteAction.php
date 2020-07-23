<?php

namespace App\Controller;

use App\Services\PlaceAutoCompleteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaceAutoCompleteAction extends AbstractController
{
    /** @var PlaceAutoCompleteService */
    private $placeAutoCompleteService;

    public function __construct(PlaceAutoCompleteService $placeAutoCompleteService)
    {
        $this->placeAutoCompleteService = $placeAutoCompleteService;
    }

    public function __invoke(Request $request, string $address): Response
    {
        $result = $this->placeAutoCompleteService->autoComplete($address);
        return $this->json($result);
    }
}