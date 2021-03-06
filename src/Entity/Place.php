<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={
            "groups" = {"places_read"}
 *     },
 *     denormalizationContext={
            "disable_type_enforcement"=true
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"places_read", "favs_read", "ride_comparisons_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"places_read", "favs_read", "ride_comparisons_read"})
     * @Assert\NotBlank(message="Le champ googlePlaceId est obligatoire")
     * @Assert\Type(type="string", message="Le champs googlePlaceId est une chaine de caractère")
     */
    private $googlePlaceId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"places_read", "favs_read", "ride_comparisons_read"})
     * @Assert\NotBlank(message="Le champ name est obligatoire")
     * @Assert\Type(type="string", message="Le champs name est une chaine de caractère")
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGooglePlaceId(): ?string
    {
        return $this->googlePlaceId;
    }

    public function setGooglePlaceId($googlePlaceId): self
    {
        $this->googlePlaceId = $googlePlaceId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
