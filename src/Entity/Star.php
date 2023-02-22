<?php

namespace App\Entity;

use App\Repository\StarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: StarRepository::class)]
class Star
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null; 

    #[ORM\Column]
    private ?int $mass = null;

    #[ORM\Column]
    private ?int $temperature = null;

    #[ORM\Column]
    private ?int $diameter = null;

    #[ORM\ManyToOne(inversedBy: 'stars')]
    private ?Space $space = null;

    #[ORM\ManyToMany(targetEntity: Sky::class, mappedBy: 'stars')]
    private Collection $skies;

    #[ORM\ManyToMany(targetEntity: Type::class, inversedBy: 'stars')]
    private Collection $types;
    
    public function __construct()
    {
        $this->skies = new ArrayCollection();
        $this->types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMass(): ?int
    {
        return $this->mass;
    }

    public function setMass(int $mass): self
    {
        $this->mass = $mass;

        return $this;
    }

    public function getTemperature(): ?int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getDiameter(): ?int
    {
        return $this->diameter;
    }

    public function setDiameter(int $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getSpace(): ?Space
    {
        return $this->space;
    }

    public function setSpace(?Space $space): self
    {
        $this->space = $space;

        return $this;
    }


    public function __toString(): string
    {
        return $this->description;
    }

    /**
     * @return Collection<int, Sky>
     */
    public function getSkies(): Collection
    {
        return $this->skies;
    }

    public function addSky(Sky $sky): self
    {
        if (!$this->skies->contains($sky)) {
            $this->skies->add($sky);
            $sky->addStar($this);
        }

        return $this;
    }

    public function removeSky(Sky $sky): self
    {
        if ($this->skies->removeElement($sky)) {
            $sky->removeStar($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        $this->types->removeElement($type);

        return $this;
    }

}
