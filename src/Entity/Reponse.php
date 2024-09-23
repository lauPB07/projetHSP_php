<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenue = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure = null;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'reponse')]
    private Collection $ref_post;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'reponse')]
    private Collection $ref_user;

    public function __construct()
    {
        $this->ref_post = new ArrayCollection();
        $this->ref_user = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
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

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getRefPost(): Collection
    {
        return $this->ref_post;
    }

    public function addRefPost(Post $refPost): static
    {
        if (!$this->ref_post->contains($refPost)) {
            $this->ref_post->add($refPost);
            $refPost->setReponse($this);
        }

        return $this;
    }

    public function removeRefPost(Post $refPost): static
    {
        if ($this->ref_post->removeElement($refPost)) {
            // set the owning side to null (unless already changed)
            if ($refPost->getReponse() === $this) {
                $refPost->setReponse(null);
            }
        }

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
            $refUser->setReponse($this);
        }

        return $this;
    }

    public function removeRefUser(User $refUser): static
    {
        if ($this->ref_user->removeElement($refUser)) {
            // set the owning side to null (unless already changed)
            if ($refUser->getReponse() === $this) {
                $refUser->setReponse(null);
            }
        }

        return $this;
    }


}
