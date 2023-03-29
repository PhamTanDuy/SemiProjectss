<?php

namespace App\Entity;

use App\Repository\InventorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventorRepository::class)]
class Inventor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\OneToMany(mappedBy: 'inventor', targetEntity: Water::class)]
    private Collection $waters;

    public function __construct()
    {
        $this->waters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Water>
     */
    public function getWaters(): Collection
    {
        return $this->waters;
    }

    public function addWater(Water $water): self
    {
        if (!$this->waters->contains($water)) {
            $this->waters->add($water);
            $water->setInventor($this);
        }

        return $this;
    }

    public function removeWater(Water $water): self
    {
        if ($this->waters->removeElement($water)) {
            // set the owning side to null (unless already changed)
            if ($water->getInventor() === $this) {
                $water->setInventor(null);
            }
        }

        return $this;
    }
}
