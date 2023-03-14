<?php

namespace App\Entity;

use App\Repository\GeolocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GeolocationRepository::class)]
class Geolocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'geolocation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Station $station = null;

    #[ORM\ManyToOne(inversedBy: 'geolocations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $countryCode = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $island = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $county = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $place = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $hamlet = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $town = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $municipality = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $state_district = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $administrative = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $village = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $province = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $locality = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStationName(): ?Station
    {
        return $this->station;
    }

    public function setStationName(Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getCountryCode(): ?Country
    {
        return $this->countryCode;
    }

    public function setCountryCode(?Country $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getIsland(): ?string
    {
        return $this->island;
    }

    public function setIsland(?string $island): self
    {
        $this->island = $island;

        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(?string $county): self
    {
        $this->county = $county;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getHamlet(): ?string
    {
        return $this->hamlet;
    }

    public function setHamlet(?string $hamlet): self
    {
        $this->hamlet = $hamlet;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(?string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getMunicipality(): ?string
    {
        return $this->municipality;
    }

    public function setMunicipality(?string $municipality): self
    {
        $this->municipality = $municipality;

        return $this;
    }

    public function getStateDistrict(): ?string
    {
        return $this->state_district;
    }

    public function setStateDistrict(?string $state_district): self
    {
        $this->state_district = $state_district;

        return $this;
    }

    public function getAdministrative(): ?string
    {
        return $this->administrative;
    }

    public function setAdministrative(?string $administrative): self
    {
        $this->administrative = $administrative;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getVillage(): ?string
    {
        return $this->village;
    }

    public function setVillage(?string $village): self
    {
        $this->village = $village;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(?string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
