<?php

namespace App\Entity;

use App\Repository\QuestionSupportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionSupportRepository::class)]
class QuestionSupport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'questionSupports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $ref_user = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reponse = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'questionSupport')]
    private Collection $ref_admin;

    public function __construct()
    {
        $this->ref_admin = new ArrayCollection();
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRefUser(): ?user
    {
        return $this->ref_user;
    }

    public function setRefUser(?user $ref_user): static
    {
        $this->ref_user = $ref_user;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRefAdmin(): Collection
    {
        return $this->ref_admin;
    }

    public function addRefAdmin(User $refAdmin): static
    {
        if (!$this->ref_admin->contains($refAdmin)) {
            $this->ref_admin->add($refAdmin);
            $refAdmin->setQuestionSupport($this);
        }

        return $this;
    }

    public function removeRefAdmin(User $refAdmin): static
    {
        if ($this->ref_admin->removeElement($refAdmin)) {
            // set the owning side to null (unless already changed)
            if ($refAdmin->getQuestionSupport() === $this) {
                $refAdmin->setQuestionSupport(null);
            }
        }

        return $this;
    }
}
