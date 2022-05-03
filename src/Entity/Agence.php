<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $secteur;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'integer')]
    private $postale;

    #[ORM\Column(type: 'string', length: 255)]
    private $ville;

    #[ORM\OneToMany(mappedBy: 'agence', targetEntity: User::class)]
    private $collaborateur;

    public function __construct()
    {
        $this->collaborateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPostale(): ?int
    {
        return $this->postale;
    }

    public function setPostale(int $postale): self
    {
        $this->postale = $postale;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getCollaborateur(): Collection
    {
        return $this->collaborateur;
    }

    public function addCollaborateur(User $collaborateur): self
    {
        if (!$this->collaborateur->contains($collaborateur)) {
            $this->collaborateur[] = $collaborateur;
            $collaborateur->setAgence($this);
        }

        return $this;
    }

    public function removeCollaborateur(User $collaborateur): self
    {
        if ($this->collaborateur->removeElement($collaborateur)) {
            // set the owning side to null (unless already changed)
            if ($collaborateur->getAgence() === $this) {
                $collaborateur->setAgence(null);
            }
        }

        return $this;
    }
}
