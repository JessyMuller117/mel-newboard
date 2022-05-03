<?php

namespace App\Entity;

use App\Repository\MessageCMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageCMRepository::class)]
class MessageCM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $texte;

    #[ORM\OneToMany(mappedBy: 'messageCM', targetEntity: ImageCM::class, orphanRemoval: true, cascade: ['persist'])]
    private $contenu_image;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'message_cm')]
    private $client;

    public function __construct()
    {
        $this->contenu_image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * @return Collection<int, ImageCM>
     */
    public function getContenuImage(): Collection
    {
        return $this->contenu_image;
    }

    public function addContenuImage(ImageCM $contenuImage): self
    {
        if (!$this->contenu_image->contains($contenuImage)) {
            $this->contenu_image[] = $contenuImage;
            $contenuImage->setMessageCM($this);
        }

        return $this;
    }

    public function removeContenuImage(ImageCM $contenuImage): self
    {
        if ($this->contenu_image->removeElement($contenuImage)) {
            // set the owning side to null (unless already changed)
            if ($contenuImage->getMessageCM() === $this) {
                $contenuImage->setMessageCM(null);
            }
        }

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }
}
