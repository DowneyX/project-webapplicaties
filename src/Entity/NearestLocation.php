<?php

namespace App\Entity;

use App\Repository\NearestLocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NearestLocationRepository::class)]
class NearestLocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'nearestLocation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Station $station = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $administrative_region1 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $administrative_region2 = null;

    #[ORM\ManyToOne(inversedBy: 'nearest_location')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country_code = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdministrativeRegion1(): ?string
    {
        return $this->administrative_region1;
    }

    public function setAdministrativeRegion1(?string $administrative_region1): self
    {
        $this->administrative_region1 = $administrative_region1;

        return $this;
    }

    public function getAdministrativeRegion2(): ?string
    {
        return $this->administrative_region2;
    }

    public function setAdministrativeRegion2(?string $administrative_region2): self
    {
        $this->administrative_region2 = $administrative_region2;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountryCode(): Collection
    {
        return $this->country_code;
    }

    public function addCountryCode(Country $countryCode): self
    {
        if (!$this->country_code->contains($countryCode)) {
            $this->country_code->add($countryCode);
            $countryCode->setNearestLocation($this);
        }

        return $this;
    }

    public function removeCountryCode(Country $countryCode): self
    {
        if ($this->country_code->removeElement($countryCode)) {
            // set the owning side to null (unless already changed)
            if ($countryCode->getNearestLocation() === $this) {
                $countryCode->setNearestLocation(null);
            }
        }

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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
