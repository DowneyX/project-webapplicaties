<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'contracts')]
    private Collection $user;

    #[ORM\Column(nullable: true)]
    private ?float $min_latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $max_latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $min_longitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $max_longitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $min_elevation = null;

    #[ORM\Column(nullable: true)]
    private ?float $max_elevation = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    public function getMinLatitude(): ?float
    {
        return $this->min_latitude;
    }

    public function setMinLatitude(?float $min_latitude): self
    {
        $this->min_latitude = $min_latitude;

        return $this;
    }

    public function getMaxLatitude(): ?float
    {
        return $this->max_latitude;
    }

    public function setMaxLatitude(?float $max_latitude): self
    {
        $this->max_latitude = $max_latitude;

        return $this;
    }

    public function getMinLongitude(): ?float
    {
        return $this->min_longitude;
    }

    public function setMinLongitude(?float $min_longitude): self
    {
        $this->min_longitude = $min_longitude;

        return $this;
    }

    public function getMaxLongitude(): ?float
    {
        return $this->max_longitude;
    }

    public function setMaxLongitude(?float $max_longitude): self
    {
        $this->max_longitude = $max_longitude;

        return $this;
    }

    public function getMinElevation(): ?float
    {
        return $this->min_elevation;
    }

    public function setMinElevation(?float $min_elevation): self
    {
        $this->min_elevation = $min_elevation;

        return $this;
    }

    public function getMaxElevation(): ?float
    {
        return $this->max_elevation;
    }

    public function setMaxElevation(?float $max_elevation): self
    {
        $this->max_elevation = $max_elevation;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
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
}
