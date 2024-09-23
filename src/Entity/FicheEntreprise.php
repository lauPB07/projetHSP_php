<?php

namespace App\Entity;

use App\Repository\FicheEntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheEntrepriseRepository::class)]
class FicheEntreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column(length: 255)]
    private ?string $cp = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_web = null;

    #[ORM\ManyToOne(inversedBy: 'ref_entreprise')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Offre>
     */
    #[ORM\ManyToMany(targetEntity: Offre::class, mappedBy: 'ref_EntrepriseCreer')]
    private Collection $offres;

    /**
     * @var Collection<int, Offre>
     */
    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'ficheEntreprises')]
    private Collection $ref_OffreCreer;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
        $this->ref_OffreCreer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): static
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresseWeb(): ?string
    {
        return $this->adresse_web;
    }

    public function setAdresseWeb(string $adresse_web): static
    {
        $this->adresse_web = $adresse_web;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): static
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->addRefEntrepriseCreer($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        if ($this->offres->removeElement($offre)) {
            $offre->removeRefEntrepriseCreer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getRefOffreCreer(): Collection
    {
        return $this->ref_OffreCreer;
    }

    public function addRefOffreCreer(Offre $refOffreCreer): static
    {
        if (!$this->ref_OffreCreer->contains($refOffreCreer)) {
            $this->ref_OffreCreer->add($refOffreCreer);
        }

        return $this;
    }

    public function removeRefOffreCreer(Offre $refOffreCreer): static
    {
        $this->ref_OffreCreer->removeElement($refOffreCreer);

        return $this;
    }
}
