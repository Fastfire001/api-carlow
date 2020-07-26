<?php

namespace App\Controller;

use App\Entity\Fav;
use App\Entity\Place;
use App\Repository\FavRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddFavAction extends AbstractController
{

    /** @var FavRepository */
    private $favRepository;

    public function __construct(FavRepository $favRepository)
    {
        $this->favRepository = $favRepository;
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['favName']) || empty($data['placeName']) || empty($data['googlePlaceId'])) {
            return $this->json(['error' => 'favName, placeName and googlePlaceId are required in body'], 400);
        }

        $fav = $this->favRepository->findOneBy([
            'user' => $this->getUser(),
            'name' => $data['favName']
        ]);
        if ($fav === null) {
            $fav = new Fav();
        }

        $em = $this->getDoctrine()->getManager();
        $place = new Place();
        $place->setName($data['placeName'])
            ->setGooglePlaceId($data['googlePlaceId']);

        $em->persist($place);

        $fav->setUser($this->getUser())
            ->setName($data['favName'])
            ->setPlace($place);

        $em->persist($fav);
        $em->flush();

        return $this->json('ok');
    }
}