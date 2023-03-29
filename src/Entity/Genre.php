<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $GenreName = null;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: Water::class)]
    private Collection $waters;

    public function __construct()
    {
        $this->waters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenreName(): ?string
    {
        return $this->GenreName;
    }

    public function setGenreName(string $GenreName): self
    {
        $this->GenreName = $GenreName;

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
            $water->setGenre($this);
        }

        return $this;
    }

    public function removeWater(Water $water): self
    {
        if ($this->waters->removeElement($water)) {
            // set the owning side to null (unless already changed)
            if ($water->getGenre() === $this) {
                $water->setGenre(null);
            }
        }

        return $this;
    }
}
