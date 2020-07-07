<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={
            "groups" = {"users_read"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Le cham email doit être unique")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"users_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"users_read"})
     * @Assert\NotBlank(message="Le champ est mail est obligatoire")
     * @Assert\Email(message="Le champ mail doit avoir un format valide")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"users_read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le champ password est obligatoire")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fav", mappedBy="user")
     */
    private $favs;

    /**
     * @ORM\Column(type="integer")
     */
    private $savingPrice;

    /**
     * @ORM\OneToMany(targetEntity=Ride::class, mappedBy="user", orphanRemoval=true)
     */
    private $rides;

    public function __construct()
    {
        $this->favs = new ArrayCollection();
        $this->rides = new ArrayCollection();
        $this->savingPrice = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Fav[]
     */
    public function getFavs(): Collection
    {
        return $this->favs;
    }

    public function addFav(Fav $fav): self
    {
        if (!$this->favs->contains($fav)) {
            $this->favs[] = $fav;
            $fav->setUser($this);
        }

        return $this;
    }

    public function removeFav(Fav $fav): self
    {
        if ($this->favs->contains($fav)) {
            $this->favs->removeElement($fav);
            // set the owning side to null (unless already changed)
            if ($fav->getUser() === $this) {
                $fav->setUser(null);
            }
        }

        return $this;
    }

    public function getSavingPrice(): ?int
    {
        return $this->savingPrice;
    }

    public function setSavingPrice(int $savingPrice): self
    {
        $this->savingPrice = $savingPrice;

        return $this;
    }

    /**
     * @return Collection|Ride[]
     */
    public function getRides(): Collection
    {
        return $this->rides;
    }

    public function addRide(Ride $ride): self
    {
        if (!$this->rides->contains($ride)) {
            $this->rides[] = $ride;
            $ride->setUser($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->contains($ride)) {
            $this->rides->removeElement($ride);
            // set the owning side to null (unless already changed)
            if ($ride->getUser() === $this) {
                $ride->setUser(null);
            }
        }

        return $this;
    }
}
