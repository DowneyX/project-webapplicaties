<?php

namespace App\Entity;

use App\Repository\FaultyMeasurementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FaultyMeasurementRepository::class)]
class FaultyMeasurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'faultyMeasurement', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Measurement $measurement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeasurement(): ?Measurement
    {
        return $this->measurement;
    }

    public function setMeasurement(Measurement $measurement): self
    {
        $this->measurement = $measurement;

        return $this;
    }
}
