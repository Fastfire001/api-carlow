<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RideComparisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RideComparisonRepository::class)
 * @ApiResource(
 *     normalizationContext={
            "groups" = {"ride_comparisons_read"}
 *     }
 * )
 */
class RideComparison
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Ride::class, mappedBy="rideComparison")
     * @Groups({"ride_comparisons_read"})
     */
    private $rides;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $maxPrice;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $distance;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $duration;

    public function __construct()
    {
        $this->rides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $ride->setRideComparison($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->contains($ride)) {
            $this->rides->removeElement($ride);
            // set the owning side to null (unless already changed)
            if ($ride->getRideComparison() === $this) {
                $ride->setRideComparison(null);
            }
        }

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
