<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['adherent:read','adherent:write'])]
    private ?\DateTimeInterface $dateSortie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write'])]
    private ?string $langue = null;

    #[ORM\Column(length: 255)]
    #[Groups(['adherent:read','adherent:write'])]
    private ?string $photoCouverture = null;

    #[ORM\OneToMany(mappedBy: 'Correspondre', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\OneToOne(mappedBy: 'Lier', cascade: ['persist', 'remove'])]
    private ?Reservations $reservations = null;

    #[ORM\ManyToMany(targetEntity: Auteur::class, mappedBy: 'Ecrire')]
    #[Groups(['adherent:read','adherent:write'])]
    private Collection $auteurs;

    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'Appartenir')]
    #[Groups(['adherent:read','adherent:write'])]
    private Collection $categories;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->auteurs = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): static
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): static
    {
        $this->langue = $langue;

        return $this;
    }

    public function getPhotoCouverture(): ?string
    {
        return $this->photoCouverture;
    }

    public function setPhotoCouverture(string $photoCouverture): static
    {
        $this->photoCouverture = $photoCouverture;

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): static
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setCorrespondre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getCorrespondre() === $this) {
                $emprunt->setCorrespondre(null);
            }
        }

        return $this;
    }

    public function getReservations(): ?Reservations
    {
        return $this->reservations;
    }

    public function setReservations(?Reservations $reservations): static
    {
        // unset the owning side of the relation if necessary
        if ($reservations === null && $this->reservations !== null) {
            $this->reservations->setLier(null);
        }

        // set the owning side of the relation if necessary
        if ($reservations !== null && $reservations->getLier() !== $this) {
            $reservations->setLier($this);
        }

        $this->reservations = $reservations;

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
            $auteur->addEcrire($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        if ($this->auteurs->removeElement($auteur)) {
            $auteur->removeEcrire($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (count($this->categories) < 3) {
            if (!$this->categories->contains($category)) {
                $this->categories->add($category);
                $category->addAppartenir($this);
            }
        } else {
            throw new \Exception("Un adhérent ne peut pas avoir plus de 3 catégories.");
        }
        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeAppartenir($this);
        }

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
