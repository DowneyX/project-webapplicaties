<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Station::class, inversedBy: "measurements")]
    private ?Station $station = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(nullable: true)]
    private ?float $temperature = null;

    #[ORM\Column (nullable: true)]
    private ?float $dew_point = null;

    #[ORM\Column (nullable: true)]
    private ?float $station_air_pressure = null;

    #[ORM\Column (nullable: true)]
    private ?float $sea_level_air_pressure = null;

    #[ORM\Column (nullable: true)]
    private ?float $wind_speed = null;

    #[ORM\Column (nullable: true)]
    private ?float $precipitation = null;

    #[ORM\Column (nullable: true)]
    private ?float $snow_depth = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $FRSHTT = null;

    #[ORM\Column (nullable: true)]
    private ?float $cloud_percentage = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $wind_direction = null;

    #[ORM\OneToOne(mappedBy: 'measurement', cascade: ['persist', 'remove'])]
    private ?FaultyMeasurement $faultyMeasurement = null;

    #[ORM\Column(nullable: true)]
    private ?float $visibility = null;

    #[ORM\Column(type: 'array', nullable: true)]
    private ?array $faults = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getDewPoint(): ?float
    {
        return $this->dew_point;
    }

    public function setDewPoint(?float $dew_point): self
    {
        $this->dew_point = $dew_point;

        return $this;
    }

    public function getStationAirPressure(): ?float
    {
        return $this->station_air_pressure;
    }

    public function setStationAirPressure(?float $station_air_pressure): self
    {
        $this->station_air_pressure = $station_air_pressure;

        return $this;
    }

    public function getSeaLevelAirPressure(): ?float
    {
        return $this->sea_level_air_pressure;
    }

    public function setSeaLevelAirPressure(?float $sea_level_air_pressure): self
    {
        $this->sea_level_air_pressure = $sea_level_air_pressure;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(?float $wind_speed): self
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getPrecipitation(): ?float
    {
        return $this->precipitation;
    }

    public function setPrecipitation(?float $precipitation): self
    {
        $this->precipitation = $precipitation;

        return $this;
    }

    public function getSnowDepth(): ?float
    {
        return $this->snow_depth;
    }

    public function setSnowDepth(?float $snow_depth): self
    {
        $this->snow_depth = $snow_depth;

        return $this;
    }

    public function getFRSHTT(): ?string
    {
        return $this->FRSHTT;
    }

    public function setFRSHTT(?string $FRSHTT): self
    {
        $this->FRSHTT = $FRSHTT;

        return $this;
    }

    public function getCloudPercentage(): ?float
    {
        return $this->cloud_percentage;
    }

    public function setCloudPercentage(?float $cloud_percentage): self
    {
        $this->cloud_percentage = $cloud_percentage;

        return $this;
    }

    public function getWindDirection(): ?int
    {
        return $this->wind_direction;
    }

    public function setWindDirection(?int $wind_direction): self
    {
        $this->wind_direction = $wind_direction;

        return $this;
    }

    public function getFaultyMeasurement(): ?FaultyMeasurement
    {
        return $this->faultyMeasurement;
    }

    public function setFaultyMeasurement(FaultyMeasurement $faultyMeasurement): self
    {
        // set the owning side of the relation if necessary
        if ($faultyMeasurement->getMeasurement() !== $this) {
            $faultyMeasurement->setMeasurement($this);
        }

        $this->faultyMeasurement = $faultyMeasurement;

        return $this;
    }

    public function getVisibility(): ?float
    {
        return $this->visibility;
    }

    public function setVisibility(?float $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getFaults(): ?array
    {
        return $this->faults;
    }

    public function addFault(?string $fault): self
    {
        if (!in_array($fault, $this->faults)) {
            $this->faults[] = $fault;
        }

        return $this;
    }
}
