<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RideRepository::class)
 */
class Ride
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vtc::class, inversedBy="rides")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"ride_comparisons_read"})
     */
    private $Vtc;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class)
     * @Groups({"ride_comparisons_read"})
     */
    private $Options;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"ride_comparisons_read"})
     */
    private $startPosition;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"ride_comparisons_read"})
     */
    private $endPosition;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rides")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=RideComparison::class, inversedBy="rides")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rideComparison;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $timeBeforeDeparture;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ride_comparisons_read"})
     */
    private $emission;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOrdered;

    public function __construct()
    {
        $this->Options = new ArrayCollection();
        $this->setIsOrdered(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVtc(): ?Vtc
    {
        return $this->Vtc;
    }

    public function setVtc(?Vtc $Vtc): self
    {
        $this->Vtc = $Vtc;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->Options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->Options->contains($option)) {
            $this->Options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->Options->contains($option)) {
            $this->Options->removeElement($option);
        }

        return $this;
    }

    public function getStartPosition(): ?Place
    {
        return $this->startPosition;
    }

    public function setStartPosition(?Place $startPosition): self
    {
        $this->startPosition = $startPosition;

        return $this;
    }

    public function getEndPosition(): ?Place
    {
        return $this->endPosition;
    }

    public function setEndPosition(?Place $endPosition): self
    {
        $this->endPosition = $endPosition;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getRideComparison(): ?RideComparison
    {
        return $this->rideComparison;
    }

    public function setRideComparison(?RideComparison $rideComparison): self
    {
        $this->rideComparison = $rideComparison;

        return $this;
    }

    public function getTimeBeforeDeparture(): ?int
    {
        return $this->timeBeforeDeparture;
    }

    public function setTimeBeforeDeparture(int $timeBeforeDeparture): self
    {
        $this->timeBeforeDeparture = $timeBeforeDeparture;

        return $this;
    }

    public function getEmission(): ?int
    {
        return $this->emission;
    }

    public function setEmission(int $emission): self
    {
        $this->emission = $emission;

        return $this;
    }

    public function getIsOrdered(): ?bool
    {
        return $this->isOrdered;
    }

    public function setIsOrdered(bool $isOrdered): self
    {
        $this->isOrdered = $isOrdered;

        return $this;
    }
}
