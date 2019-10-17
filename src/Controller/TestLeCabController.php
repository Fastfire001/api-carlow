<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class TestLeCabController
 * @package App\Controller
 * @Route("/test/le/cab")
 */
class TestLeCabController extends AbstractController
{

    private $apiKey = '89696335d20acc59d7060642ba312cc6';
    private $endPoint = 'https://testapi.lecab.fr/release';

    /**
     * @Route("/", name="test_le_cab")
     */
    public function index()
    {
        return $this->render('test_le_cab/index.html.twig', [
            'controller_name' => 'TestLeCabController',
        ]);
    }

    public function checkServerStatus()
    {
        $request = HttpClient::create();
        $response = $request->request('GET', $this->endPoint . '/server/status');
        return $response->getStatusCode() !== 200 ? false : true;
    }

    /**
     * @Route("/services/available", name="test_le_cab_service_available")
     */
    public function serviceAvailable()
    {
        if ($this->checkServerStatus()) {
            $r = HttpClient::create();
            $response = $r->request('POST', $this->endPoint . '/services/available', [
                'json' => [
                    'location' => [
                        'address' => '12 rue médéric',
                    ]
                ]
            ]);
            return $this->json(json_decode($response->getContent(), true));
        }
        return $this->redirectToRoute('test_le_cab');
    }

    /**
     * @Route("/services/estimate", name="test_le_cab_service_estimate")
     */
    public function serviceEstimate()
    {
        if ($this->checkServerStatus()) {
            $r = HttpClient::create([
                'headers' => [
                    'Authorization' => 'X-Api-Key 89696335d20acc59d7060642ba312cc6'
                ]
            ]);
            $response = $r->request('POST', $this->endPoint . '/services/estimate', [
                'json' => [
                    'location' => [
                        'address' => '12 rue médéric',
                    ],
                    'service' => 'P508',
                    'payment' => [
                        'type' => 'CARD',
                    ],
                ],
            ]);
            dump($response->getStatusCode());
            return $this->json(json_decode($response->getContent(), true));
        }
    }

    /**
     * @Route("/locations/search", name="test_le_cab_locations_search")
     */
    public function locationSearch()
    {
        if ($this->checkServerStatus()) {
            $r = HttpClient::create();
            $response = $r->request('POST', $this->endPoint . '/locations/search', [
                'json' => [
                    'location' => [
                        'address' => '25 avenue victor hugo les clayes sous bois',
                    ],
                    'limit' => '5',
                ],
            ]);
            dump($response->getStatusCode());
            return $this->json(json_decode($response->getContent(), true));
        }
    }

    /**
     * @Route("/jobs/estimate", name="test_le_cab_jobs_estimate")
     */
    public function jobsEstimate()
    {
        if ($this->checkServerStatus()) {
            $r = HttpClient::create([
                'headers' => [
                    'Authorization' => 'X-Api-Key 89696335d20acc59d7060642ba312cc6',
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'application/json',
                ]
            ]);
            $response = $r->request('POST', $this->endPoint . '/jobs/estimate', [
                'json' => [
                    'pickup' => [
                        'latitude' => 48.880501,
                        'longitude' => 2.30323,
                    ],
                    'drop' => [
                        'latitude' => 48.8251,
                        'longitude' => 1.97886,
                    ],
                    'service' => 'P508',
                ],
            ]);
            dump($response->getStatusCode());
            return $this->json(json_decode($response->getContent(), true));
        }
    }
}
