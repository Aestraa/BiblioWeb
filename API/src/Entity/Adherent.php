<?php

namespace App\Entity;

use App\Repository\AdherentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdherentRepository::class)]
class Adherent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAdhesion = null;

    #[ORM\ManyToMany(targetEntity: Emprunt::class, mappedBy: 'Relier')]
    private Collection $emprunts;

    #[ORM\OneToMany(mappedBy: 'Faire', targetEntity: Reservations::class)]
    private Collection $reservations;

    #[ORM\OneToOne(mappedBy: 'est', cascade: ['persist', 'remove'])]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAdhesion(): ?\DateTimeInterface
    {
        return $this->dateAdhesion;
    }

    public function setDateAdhesion(\DateTimeInterface $dateAdhesion): static
    {
        $this->dateAdhesion = $dateAdhesion;

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
        if (count($this->emprunts) < 5) {
            if (!$this->emprunts->contains($emprunt)) {
                $this->emprunts->add($emprunt);
                $emprunt->addRelier($this);
            }
        } else {
            throw new \Exception("Un adhérent ne peut pas avoir plus de 5 emprunts.");
        }
        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            $emprunt->removeRelier($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): static
    {
        if (count($this->reservations) < 3) {
            if (!$this->reservations->contains($reservation)) {
                $this->reservations->add($reservation);
                $reservation->setFaire($this);
            }
        } else {
            throw new \Exception("Un adhérent ne peut pas avoir plus de 3 réservations.");
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getFaire() === $this) {
                $reservation->setFaire(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        // unset the owning side of the relation if necessary
        if ($utilisateur === null && $this->utilisateur !== null) {
            $this->utilisateur->setEst(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateur !== null && $utilisateur->getEst() !== $this) {
            $utilisateur->setEst($this);
        }

        $this->utilisateur = $utilisateur;

        return $this;
    }
}
