<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={
            "groups" = {"favs_read"}
 *     },
 *     denormalizationContext={
            "disable_type_enforcement"=true
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FavRepository")
 * @UniqueEntity("place", message="Le champ place doit être unique")
 */
class Fav
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"favs_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"favs_read"})
     * @Assert\NotBlank(message="Le champ name est obligatoire")
     * @Assert\Type(type="string", message="Le champ name est une chaine de caractère")
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Place", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"favs_read"})
     * @Assert\NotBlank(message="Le champ place est obligatoire")
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="favs")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Le champ user est obligatoire")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
