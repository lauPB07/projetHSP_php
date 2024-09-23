<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $canal = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'post')]
    private Collection $ref_user;

    #[ORM\ManyToOne(inversedBy: 'ref_post')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reponse $reponse = null;

    public function __construct()
    {
        $this->ref_user = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCanal(): ?string
    {
        return $this->canal;
    }

    public function setCanal(string $canal): static
    {
        $this->canal = $canal;

        return $this;
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

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(string $contenue): static
    {
        $this->contenue = $contenue;

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

    /**
     * @return Collection<int, User>
     */
    public function getRefUser(): Collection
    {
        return $this->ref_user;
    }

    public function addRefUser(User $refUser): static
    {
        if (!$this->ref_user->contains($refUser)) {
            $this->ref_user->add($refUser);
            $refUser->setPost($this);
        }

        return $this;
    }

    public function removeRefUser(User $refUser): static
    {
        if ($this->ref_user->removeElement($refUser)) {
            // set the owning side to null (unless already changed)
            if ($refUser->getPost() === $this) {
                $refUser->setPost(null);
            }
        }

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

}
