<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "string", length: 10, nullable: false)]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $elevation = null;

    #[ORM\OneToOne(mappedBy: 'station_name', cascade: ['persist', 'remove'])]
    private ?NearestLocation $nearestLocation = null;

    #[ORM\OneToOne(mappedBy: 'station_name', cascade: ['persist', 'remove'])]
    private ?Geolocation $geolocation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getElevation(): ?float
    {
        return $this->elevation;
    }

    public function setElevation(float $elevation): self
    {
        $this->elevation = $elevation;

        return $this;
    }

    public function getNearestLocation(): ?NearestLocation
    {
        return $this->nearestLocation;
    }

    public function setNearestLocation(NearestLocation $nearestLocation): self
    {
        // set the owning side of the relation if necessary
        if ($nearestLocation->getStationName() !== $this) {
            $nearestLocation->setStationName($this);
        }

        $this->nearestLocation = $nearestLocation;

        return $this;
    }

    public function getGeolocation(): ?Geolocation
    {
        return $this->geolocation;
    }

    public function setGeolocation(Geolocation $geolocation): self
    {
        // set the owning side of the relation if necessary
        if ($geolocation->getStationName() !== $this) {
            $geolocation->setStationName($this);
        }

        $this->geolocation = $geolocation;

        return $this;
    }
}
