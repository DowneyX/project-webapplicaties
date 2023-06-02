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

    #[ORM\Column(nullable: false)]
    private ?string $api_key = null;

    #[ORM\Column(nullable: false, length: 4000)]
    private ?string $query_stations = null;

    #[ORM\Column(nullable: false, length: 4000)]
    private ?string $query_measurments = null;

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

    public function getQueryStations(): ?string
    {
        return $this->query_stations;
    }

    public function setQueryStations(string $query): self
    {
        $this->query_stations = $query;
        return $this;
    }

    public function getQueryMeasurments(): ?string
    {
        return $this->query_measurments;
    }

    public function setQueryMeasurments(string $query): self
    {
        $this->query_measurments = $query;
        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->api_key;
    }

    public function setApiKey(string $name): self
    {
        $this->api_key = hash('sha512', $name);

        return $this;
    }
}