<?php

namespace App\Services;

use App\Entity\Place;
use Symfony\Component\HttpClient\HttpClient;

class GoogleDistanceMatrixApiService
{
    /** @var string */
    private $apiKey;

    /** @var string */
    const END_POINT = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
    }

    private function buildUrl(Place $startPlace, Place $endPlace): string
    {
        $query = [
            'origins' => 'place_id:' . $startPlace->getGooglePlaceId(),
            'destinations' => 'place_id:' . $endPlace->getGooglePlaceId(),
            'language' => 'fr',
            'key' => $this->apiKey,
        ];
        return self::END_POINT . '?' . http_build_query($query);
    }

    public function getDistanceAndDuration(Place $startPlace, Place $endPlace): array
    {
        $r = HttpClient::create();
        $response = $r->request('GET', $this->buildUrl($startPlace, $endPlace));
        $data = json_decode($response->getContent(), true);
        return [
            'distance' => $data['rows'][0]['elements'][0]['distance']['value'],
            'duration' => $data['rows'][0]['elements'][0]['duration']['value'],
        ];
    }
}