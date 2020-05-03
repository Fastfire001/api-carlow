<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaceId(): ?string
    {
        return $this->place_id;
    }

    public function setPlaceId(string $place_id): self
    {
        $this->place_id = $place_id;

        return $this;
    }
}
