<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $mission_lier = null;

    #[ORM\Column(nullable: true)]
    private ?float $salaire = null;



    #[ORM\Column]
    private ?bool $est_cloturer = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'ref_offrePostule')]
    private Collection $users;

    /**
     * @var Collection<int, User>
     */

    /**
     * @var Collection<int, FicheEntreprise>
     */
    #[ORM\ManyToMany(targetEntity: FicheEntreprise::class, inversedBy: 'offres')]
    private Collection $ref_EntrepriseCreer;



    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?TypeOffre $ref_typeOffre = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?User $ref_userCreer = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->ref_EntrepriseCreer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMissionLier(): ?string
    {
        return $this->mission_lier;
    }

    public function setMissionLier(string $mission_lier): static
    {
        $this->mission_lier = $mission_lier;

        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(?float $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }


    public function isEstCloturer(): ?bool
    {
        return $this->est_cloturer;
    }

    public function setEstCloturer(bool $est_cloturer): static
    {
        $this->est_cloturer = $est_cloturer;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addRefOffrePostule($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeRefOffrePostule($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRefUserPostule(): Collection
    {
        return $this->ref_UserPostule;
    }

    public function addRefUserPostule(User $refUserPostule): static
    {
        if (!$this->ref_UserPostule->contains($refUserPostule)) {
            $this->ref_UserPostule->add($refUserPostule);
        }

        return $this;
    }

    public function removeRefUserPostule(User $refUserPostule): static
    {
        $this->ref_UserPostule->removeElement($refUserPostule);

        return $this;
    }

    /**
     * @return Collection<int, FicheEntreprise>
     */
    public function getRefEntrepriseCreer(): Collection
    {
        return $this->ref_EntrepriseCreer;
    }

    public function addRefEntrepriseCreer(FicheEntreprise $refEntrepriseCreer): static
    {
        if (!$this->ref_EntrepriseCreer->contains($refEntrepriseCreer)) {
            $this->ref_EntrepriseCreer->add($refEntrepriseCreer);
        }

        return $this;
    }

    public function removeRefEntrepriseCreer(FicheEntreprise $refEntrepriseCreer): static
    {
        $this->ref_EntrepriseCreer->removeElement($refEntrepriseCreer);

        return $this;
    }


    public function getRefTypeOffre(): ?TypeOffre
    {
        return $this->ref_typeOffre;
    }

    public function setRefTypeOffre(?TypeOffre $ref_typeOffre): static
    {
        $this->ref_typeOffre = $ref_typeOffre;

        return $this;
    }

    public function getRefUserCreer(): ?User
    {
        return $this->ref_userCreer;
    }

    public function setRefUserCreer(?User $ref_userCreer): static
    {
        $this->ref_userCreer = $ref_userCreer;

        return $this;
    }
}
