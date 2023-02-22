<?php

namespace App\Entity;

use App\Repository\SpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpaceRepository::class)]
class Space
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'space', targetEntity: Star::class, cascade: ["persist"])]
    private Collection $stars;

    #[ORM\ManyToOne(inversedBy: 'spaces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

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
            $star->setSpace($this);
        }

        return $this;
    }

    public function removeStar(Star $star): self
    {
        if ($this->stars->removeElement($star)) {
            // set the owning side to null (unless already changed)
            if ($star->getSpace() === $this) {
                $star->setSpace(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function __toString(): string
    {
        return $this->description;
    }


}
