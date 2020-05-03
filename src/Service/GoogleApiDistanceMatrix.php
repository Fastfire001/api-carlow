<?php


namespace App\Service;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GoogleApiDistanceMatrix
{
    const END_POINT = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    /** @var string */
    private $privateKey;

    public function __construct()
    {
        /*todo set private key in .env*/
        $this->privateKey = '';
    }

    public function callApi(string $origin, string $destination, string $unit = 'metric')
    {
        $request = HttpClient::create();
        try {
            $response = $request->request('GET', $this->buildUrl($origin, $destination, $unit));
            return json_decode($response->getContent(), true);
        } catch (TransportExceptionInterface $e) {
            dump($e);
        }

    }

    private function buildUrl(string $origin, string $destination, string $unit)
    {
        return self::END_POINT . "?units=$unit&origins=$origin&destinations=$destination&key=" . $this->privateKey;
    }
}