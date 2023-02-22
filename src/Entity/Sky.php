<?php

namespace App\Entity;

use App\Repository\SkyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkyRepository::class)]
class Sky
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $publish = false;

    #[ORM\ManyToOne(inversedBy: 'skies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $createur = null;

    #[ORM\ManyToMany(targetEntity: Star::class, inversedBy: 'skies')]
    private Collection $stars;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    public function getCreateur(): ?Member
    {
        return $this->createur;
    }

    public function setCreateur(?Member $createur): self
    {
        $this->createur = $createur;

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
        }

        return $this;
    }

    public function removeStar(Star $star): self
    {
        $this->stars->removeElement($star);

        return $this;
    }

    
    public function __toString(): string
    {
        return $this->description;
    }
}
