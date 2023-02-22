<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Space::class)]
    private Collection $spaces;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Sky::class, orphanRemoval: true)]
    private Collection $skies;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->spaces = new ArrayCollection();
        $this->skies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Space>
     */
    public function getSpaces(): Collection
    {
        return $this->spaces;
    }

    public function addSpace(Space $space): self
    {
        if (!$this->spaces->contains($space)) {
            $this->spaces->add($space);
            $space->setMember($this);
        }

        return $this;
    }

    public function removeSpace(Space $space): self
    {
        if ($this->spaces->removeElement($space)) {
            // set the owning side to null (unless already changed)
            if ($space->getMember() === $this) {
                $space->setMember(null);
            }
        }

        return $this;
    }


    public function __toString(): string
    {
        return $this->name;
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
            $sky->setCreateur($this);
        }

        return $this;
    }

    public function removeSky(Sky $sky): self
    {
        if ($this->skies->removeElement($sky)) {
            // set the owning side to null (unless already changed)
            if ($sky->getCreateur() === $this) {
                $sky->setCreateur(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
