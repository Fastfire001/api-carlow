<?php

namespace App\Entity;

use App\Repository\VtcRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VtcRepository::class)
 */
class Vtc
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
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $indemnification;

    /**
     * @ORM\Column(type="integer")
     */
    private $pricePerKilometer;

    /**
     * @ORM\Column(type="integer")
     */
    private $pricePerMinute;

    /**
     * @ORM\OneToMany(targetEntity=Ride::class, mappedBy="Vtc")
     */
    private $rides;

    public function __construct()
    {
        $this->rides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIndemnification(): ?int
    {
        return $this->indemnification;
    }

    public function setIndemnification(int $indemnification): self
    {
        $this->indemnification = $indemnification;

        return $this;
    }

    public function getPricePerKilometer(): ?int
    {
        return $this->pricePerKilometer;
    }

    public function setPricePerKilometer(int $pricePerKilometer): self
    {
        $this->pricePerKilometer = $pricePerKilometer;

        return $this;
    }

    public function getPricePerMinute(): ?int
    {
        return $this->pricePerMinute;
    }

    public function setPricePerMinute(int $pricePerMinute): self
    {
        $this->pricePerMinute = $pricePerMinute;

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
            $ride->setVtc($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->contains($ride)) {
            $this->rides->removeElement($ride);
            // set the owning side to null (unless already changed)
            if ($ride->getVtc() === $this) {
                $ride->setVtc(null);
            }
        }

        return $this;
    }
}
