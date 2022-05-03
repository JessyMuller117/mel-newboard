<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\OneToMany(mappedBy: 'commercial', targetEntity: Entreprise::class)]
    private $entreprise;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: MessageCM::class)]
    private $message_cm;

    #[ORM\ManyToOne(targetEntity: Entreprise::class, inversedBy: 'employes')]
    private $employe;

    #[ORM\Column(type: 'boolean')]
    private $collaborateur_neweb;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[ORM\ManyToOne(targetEntity: Agence::class, inversedBy: 'collaborateur')]
    private $agence;

    public function __construct()
    {
        $this->entreprise = new ArrayCollection();
        $this->message_cm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    
    //le getEntreprise correspond la liste des entreprise Gerer par le commercial
    /**
     * @return Collection<int, Entreprise>
     */
    public function getEntreprise(): Collection
    {
        return $this->entreprise;
    }

    public function addEntreprise(Entreprise $entreprise): self
    {
        if (!$this->entreprise->contains($entreprise)) {
            $this->entreprise[] = $entreprise;
            $entreprise->setCommercial($this);
        }

        return $this;
    }

    public function removeEntreprise(Entreprise $entreprise): self
    {
        if ($this->entreprise->removeElement($entreprise)) {
            // set the owning side to null (unless already changed)
            if ($entreprise->getCommercial() === $this) {
                $entreprise->setCommercial(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MessageCM>
     */
    public function getMessageCm(): Collection
    {
        return $this->message_cm;
    }

    public function addMessageCm(MessageCM $messageCm): self
    {
        if (!$this->message_cm->contains($messageCm)) {
            $this->message_cm[] = $messageCm;
            $messageCm->setClient($this);
        }

        return $this;
    }

    public function removeMessageCm(MessageCM $messageCm): self
    {
        if ($this->message_cm->removeElement($messageCm)) {
            // set the owning side to null (unless already changed)
            if ($messageCm->getClient() === $this) {
                $messageCm->setClient(null);
            }
        }

        return $this;
    }


    //le getEmploye correspond l'entreprise qui emploi cet User
    public function getEmploye(): ?Entreprise
    {
        return $this->employe;
    }

    public function setEmploye(?Entreprise $employe): self
    {
        $this->employe = $employe;

        return $this;
    }

    public function getCollaborateurNeweb(): ?bool
    {
        return $this->collaborateur_neweb;
    }

    public function setCollaborateurNeweb(bool $collaborateur_neweb): self
    {
        $this->collaborateur_neweb = $collaborateur_neweb;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }
}
