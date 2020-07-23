<?php

namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;

class PlaceAutoCompleteService
{
    /** @var string */
    private $apiKey;

    /** @var string */
    const END_POINT = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';

    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
    }

    private function buildUrl(string $address): string
    {
        $query = [
            'language' => 'fr',
            'key' => $this->apiKey,
            'input' => $address
        ];
        return self::END_POINT . '?' . http_build_query($query);
    }

    public function autoComplete(string $address): array
    {
        $r = HttpClient::create();
        $response = $r->request('GET', $this->buildUrl($address));
        $data = json_decode($response->getContent(), true);
        $result = [];
        foreach ($data['predictions'] as $prediction) {
            $result[] = [
                'name' => $prediction['description'],
                'googlePlaceId' => $prediction['place_id'],
            ];
        }
        return $result;
    }
}