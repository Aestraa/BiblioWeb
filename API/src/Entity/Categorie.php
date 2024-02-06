<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource()]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write','auteur:read','auteur:write','categorie:read','categorie:write','livre:read','livre:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write','auteur:read','auteur:write','categorie:read','categorie:write','livre:read','livre:write'])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'categories')]
    #[Groups(['categorie:read','categorie:write'])]
    private Collection $Appartenir;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->Appartenir = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getAppartenir(): Collection
    {
        return $this->Appartenir;
    }

    public function addAppartenir(Livre $appartenir): static
    {
        if (!$this->Appartenir->contains($appartenir)) {
            $this->Appartenir->add($appartenir);
        }

        return $this;
    }

    public function removeAppartenir(Livre $appartenir): static
    {
        $this->Appartenir->removeElement($appartenir);

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
