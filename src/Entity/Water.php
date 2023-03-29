<?php

namespace App\Entity;

use App\Repository\WaterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WaterRepository::class)]
class Water
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $WaterName = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\Column]
    private ?float $Price = null;

    #[ORM\ManyToOne(inversedBy: 'waters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $genre = null;

    #[ORM\ManyToOne(inversedBy: 'waters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inventor $inventor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWaterName(): ?string
    {
        return $this->WaterName;
    }

    public function setWaterName(string $WaterName): self
    {
        $this->WaterName = $WaterName;

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

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getInventor(): ?Inventor
    {
        return $this->inventor;
    }

    public function setInventor(?Inventor $inventor): self
    {
        $this->inventor = $inventor;

        return $this;
    }
}
