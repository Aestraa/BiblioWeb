<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private ?\DateTime $dateNaiss = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private ?string $adressePostale = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private ?string $numTel = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private ?string $photo = null;

    #[ORM\Column]
    #[Groups(['adherent:read','adherent:write','emprunt:read','emprunt:write','reservation:read','reservation:write'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Adherent $est = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateNaiss(): ?\DateTime
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTime $dateNaiss): static
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getAdressePostale(): ?string
    {
        return $this->adressePostale;
    }

    public function setAdressePostale(string $adressePostale): static
    {
        $this->adressePostale = $adressePostale;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

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

    public function addRoles(string $roles): static
    {
        $this->roles[] = $roles;
    
        return $this;
    }
    

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEst(): ?Adherent
    {
        return $this->est;
    }

    public function setEst(?Adherent $est): static
    {
        $this->est = $est;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
