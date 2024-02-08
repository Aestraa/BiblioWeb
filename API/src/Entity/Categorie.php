<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'categories', fetch: 'LAZY')]
    private Collection $Appartenir;

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
}
