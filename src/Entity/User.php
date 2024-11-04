<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $cv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poste = null;

    #[ORM\Column]
    private ?bool $valider ;

    #[ORM\ManyToOne(targetEntity: FicheEntreprise::class, inversedBy: 'users')]
    private ?FicheEntreprise $ref_entreprise = null;  // Correction du type

    #[ORM\ManyToOne(targetEntity: Specialite::class, inversedBy: 'users')]
    private ?Specialite $ref_spe = null;  // Cela reste inchangé

    #[ORM\ManyToOne(targetEntity: Hopital::class, inversedBy: 'users')]
    private ?Hopital $ref_hopital = null;  // Cela reste inchangé

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    private ?Role $ref_role = null;

    #[ORM\ManyToOne(targetEntity: FicheEtablissement::class, inversedBy: 'users')]
    private ?FicheEtablissement $ref_etablissement = null;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'ref_user')]
    private Collection $post;

    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: 'ref_user')]
    private Collection $reponse;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'users')]
    private Collection $ref_offrePostule;

    #[ORM\ManyToMany(targetEntity: Event::class, inversedBy: 'users')]
    private Collection $ref_creerEvent;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'ref_userParticipe')]
    private Collection $events;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $formationEtudiant = null;

    /**
     * @var Collection<int, Offre>
     */
    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: 'ref_userCreer')]
    private Collection $offres;

    /**
     * @var Collection<int, QuestionSupport>
     */
    #[ORM\OneToMany(targetEntity: QuestionSupport::class, mappedBy: 'ref_admin')]
    private Collection $questionSupports;







    public function __construct()
    {
        $this->ref_offrePostule = new ArrayCollection();
        $this->ref_creerEvent = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->offres = new ArrayCollection();
        $this->questionSupports = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function isValider(): ?bool
    {
        return $this->valider;
    }

    public function setValider(bool $valider): static
    {
        $this->valider = $valider;

        return $this;
    }

    /**
     * @return Collection<int, FicheEntreprise>
     */
    public function getRefEntreprise(): ?FicheEntreprise
    {
        return $this->ref_entreprise;
    }

    public function addRefEntreprise(FicheEntreprise $refEntreprise): static
    {
        if (!$this->ref_entreprise->contains($refEntreprise)) {
            $this->ref_entreprise->add($refEntreprise);
            $refEntreprise->setUser($this);
        }

        return $this;
    }

    public function removeRefEntreprise(FicheEntreprise $refEntreprise): static
    {
        if ($this->ref_entreprise->removeElement($refEntreprise)) {
            // set the owning side to null (unless already changed)
            if ($refEntreprise->getUser() === $this) {
                $refEntreprise->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Specialite>
     */
    public function getRefSpe(): ?Specialite
    {
        return $this->ref_spe;
    }

    public function addRefSpe(Specialite $refSpe): static
    {
        if (!$this->ref_spe->contains($refSpe)) {
            $this->ref_spe->add($refSpe);
            $refSpe->setUser($this);
        }

        return $this;
    }

    public function removeRefSpe(Specialite $refSpe): static
    {
        if ($this->ref_spe->removeElement($refSpe)) {
            // set the owning side to null (unless already changed)
            if ($refSpe->getUser() === $this) {
                $refSpe->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hopital>
     */


    public function getRefHopital(): ?Hopital
    {
        return $this->ref_hopital;
    }


    public function addRefHopital(Hopital $refHopital): static
    {
        if (!$this->ref_hopital->contains($refHopital)) {
            $this->ref_hopital->add($refHopital);
            $refHopital->setUser($this);
        }

        return $this;
    }

    public function removeRefHopital(Hopital $refHopital): static
    {
        if ($this->ref_hopital->removeElement($refHopital)) {
            // set the owning side to null (unless already changed)
            if ($refHopital->getUser() === $this) {
                $refHopital->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRefRole(): ?Role
    {
        return $this->ref_role;
    }

    public function addRefRole(Role $refRole): static
    {
        if (!$this->ref_role->contains($refRole)) {
            $this->ref_role->add($refRole);
            $refRole->setUser($this);
        }

        return $this;
    }

    public function removeRefRole(Role $refRole): static
    {
        if ($this->ref_role->removeElement($refRole)) {
            // set the owning side to null (unless already changed)
            if ($refRole->getUser() === $this) {
                $refRole->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FicheEtablissement>
     */
    public function getRefEtablissement(): ?FicheEtablissement
    {
        return $this->ref_etablissement;
    }

    public function addRefEtablissement(FicheEtablissement $refEtablissement): static
    {
        if (!$this->ref_etablissement->contains($refEtablissement)) {
            $this->ref_etablissement->add($refEtablissement);
            $refEtablissement->setUser($this);
        }

        return $this;
    }

    public function removeRefEtablissement(FicheEtablissement $refEtablissement): static
    {
        if ($this->ref_etablissement->removeElement($refEtablissement)) {
            // set the owning side to null (unless already changed)
            if ($refEtablissement->getUser() === $this) {
                $refEtablissement->setUser(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, Offre>
     */
    public function getRefOffrePostule(): Collection
    {
        return $this->ref_offrePostule;
    }

    public function addRefOffrePostule(Offre $refOffrePostule): static
    {
        if (!$this->ref_offrePostule->contains($refOffrePostule)) {
            $this->ref_offrePostule->add($refOffrePostule);
        }

        return $this;
    }

    public function removeRefOffrePostule(Offre $refOffrePostule): static
    {
        $this->ref_offrePostule->removeElement($refOffrePostule);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getRefCreerEvent(): Collection
    {
        return $this->ref_creerEvent;
    }

    public function addRefCreerEvent(Event $refCreerEvent): static
    {
        if (!$this->ref_creerEvent->contains($refCreerEvent)) {
            $this->ref_creerEvent->add($refCreerEvent);
        }

        return $this;
    }

    public function removeRefCreerEvent(Event $refCreerEvent): static
    {
        $this->ref_creerEvent->removeElement($refCreerEvent);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): Event
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addRefUserParticipe($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeRefUserParticipe($this);
        }

        return $this;
    }

    public function getFormationEtudiant(): ?string
    {
        return $this->formationEtudiant;
    }

    public function setFormationEtudiant(?string $formationEtudiant): static
    {
        $this->formationEtudiant = $formationEtudiant;

        return $this;
    }


    public function getRoles(): array
    {
        $roles = [];

        if ($this->ref_role) {
            $roles[] = $this->ref_role->getNomRole();
        }

        return $roles;
    }

    public function eraseCredentials(): void
    {

        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
        // TODO: Implement getUserIdentifier() method.
    }

    public function setRefEntreprise(?FicheEntreprise $ref_entreprise): static
    {
        $this->ref_entreprise = $ref_entreprise;

        return $this;
    }

    public function setRefSpe(?Specialite $ref_spe): static
    {
        $this->ref_spe = $ref_spe;

        return $this;
    }

    public function setRefHopital(?Hopital $ref_hopital): static
    {
        $this->ref_hopital = $ref_hopital;

        return $this;
    }

    public function setRefRole(?Role $ref_role): static
    {
        $this->ref_role = $ref_role;

        return $this;
    }

    public function setRefEtablissement(?FicheEtablissement $ref_etablissement): static
    {
        $this->ref_etablissement = $ref_etablissement;

        return $this;
    }

    public function getPassword(): ?string
    {
        // TODO: Implement getPassword() method.
        return $this->mdp;
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
            $offre->setRefUserCreer($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getRefUserCreer() === $this) {
                $offre->setRefUserCreer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuestionSupport>
     */
    public function getQuestionSupports(): Collection
    {
        return $this->questionSupports;
    }

    public function addQuestionSupport(QuestionSupport $questionSupport): static
    {
        if (!$this->questionSupports->contains($questionSupport)) {
            $this->questionSupports->add($questionSupport);
            $questionSupport->setRefAdmin($this);
        }

        return $this;
    }

    public function removeQuestionSupport(QuestionSupport $questionSupport): static
    {
        if ($this->questionSupports->removeElement($questionSupport)) {
            // set the owning side to null (unless already changed)
            if ($questionSupport->getRefAdmin() === $this) {
                $questionSupport->setRefAdmin(null);
            }
        }

        return $this;
    }
}
