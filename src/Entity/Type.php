<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subTypes')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $subTypes;

    #[ORM\ManyToMany(targetEntity: Star::class, mappedBy: 'types')]
    private Collection $stars;

    public function __construct()
    {
        $this->subTypes = new ArrayCollection();
        $this->stars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubTypes(): Collection
    {
        return $this->subTypes;
    }

    public function addSubType(self $subType): self
    {
        if (!$this->subTypes->contains($subType)) {
            $this->subTypes->add($subType);
            $subType->setParent($this);
        }

        return $this;
    }

    public function removeSubType(self $subType): self
    {
        if ($this->subTypes->removeElement($subType)) {
            // set the owning side to null (unless already changed)
            if ($subType->getParent() === $this) {
                $subType->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Star>
     */
    public function getStars(): Collection
    {
        return $this->stars;
    }

    public function addStar(Star $star): self
    {
        if (!$this->stars->contains($star)) {
            $this->stars->add($star);
            $star->addType($this);
        }

        return $this;
    }

    public function removeStar(Star $star): self
    {
        if ($this->stars->removeElement($star)) {
            $star->removeType($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }

}
