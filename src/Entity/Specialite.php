<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_spe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSpe(): ?string
    {
        return $this->nom_spe;
    }

    public function setNomSpe(string $nom_spe): static
    {
        $this->nom_spe = $nom_spe;

        return $this;
    }
    public function __toString(): string
    {
       return $this->nom_spe;
    }
}
