<?php

namespace App\Entity;

use App\Entity\Adherent;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationsRepository;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateResa = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Adherent $Faire = null;

    #[ORM\OneToOne(inversedBy: 'reservations', cascade: ['persist', 'remove'])]
    private ?Livre $Lier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateResa(): ?\DateTimeInterface
    {
        return $this->dateResa;
    }

    public function setDateResa(\DateTimeInterface $dateResa): static
    {
        $this->dateResa = $dateResa;

        return $this;
    }

    public function getFaire(): ?Adherent
    {
        return $this->Faire;
    }

    public function setFaire(?Adherent $Faire): static
    {
        $this->Faire = $Faire;

        return $this;
    }

    public function getLier(): ?Livre
    {
        return $this->Lier;
    }

    public function setLier(?Livre $Lier): static
    {
        $this->Lier = $Lier;

        return $this;
    }

    // Définie dateEmprunt à la date d'aujourd'hui si aucune valeur n'est donnée ou null. 
    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->dateResa = $this->dateResa ?? new \DateTime();
    }
}
