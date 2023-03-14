<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "string", length: 10, nullable: false)]
    private ?string $id = null;

    #[ORM\Column(length: 45)]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'country_code', targetEntity: NearestLocation::class)]
    private Collection $nearestLocations;

    #[ORM\OneToMany(mappedBy: 'country_code', targetEntity: Geolocation::class)]
    private Collection $geolocations;

    public function __construct()
    {
        $this->geolocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNearestLocations(): ?Collection
    {
        return $this->nearestLocations;
    }

    public function setNearestLocations(?Collection $nearestLocations): self
    {
        $this->nearestLocations = $nearestLocations;

        return $this;
    }

    /**
     * @return Collection<int, Geolocation>
     */
    public function getGeolocations(): Collection
    {
        return $this->geolocations;
    }

    public function addGeolocation(Geolocation $geolocation): self
    {
        if (!$this->geolocations->contains($geolocation)) {
            $this->geolocations->add($geolocation);
            $geolocation->setCountryCode($this);
        }

        return $this;
    }

    public function removeGeolocation(Geolocation $geolocation): self
    {
        if ($this->geolocations->removeElement($geolocation)) {
            // set the owning side to null (unless already changed)
            if ($geolocation->getCountryCode() === $this) {
                $geolocation->setCountryCode(null);
            }
        }

        return $this;
    }
}
