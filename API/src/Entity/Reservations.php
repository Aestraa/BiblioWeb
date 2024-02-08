<?php

namespace App\Entity;

use App\Entity\Adherent;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['adherent:read','adherent:write','reservation:read','reservation:write'])]
    private ?\DateTime $dateResa = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[Groups(['reservation:read','reservation:write'])]
    private ?Adherent $Faire = null;

    #[ORM\OneToOne(inversedBy: 'reservations')]
    #[Groups(['adherent:read','adherent:write','reservation:read','reservation:write'])]
    private ?Livre $Lier = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['adherent:read','adherent:write','reservation:read','reservation:write'])]
    private ?\DateTime $dateResaFin = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateResa(): ?\DateTime
    {
        return $this->dateResa;
    }

    public function setDateResa(\DateTime $dateResa): static
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

    public function getDateResaFin(): ?\DateTime
    {
        return $this->dateResaFin;
    }

    public function setDateResaFin(\DateTime $dateResaFin): static
    {
        $this->dateResaFin = $dateResaFin;

        return $this;
    }

    // Définie dateEmprunt à la date d'aujourd'hui si aucune valeur n'est donnée ou null. 
    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->dateResa = $this->dateResa ?? new \DateTime();
        $this->dateResaFin = (clone $this->dateResa)->modify('+7 days');
    }

    
    #[ORM\PreUpdate]
    public function preUpdate(EntityManagerInterface $entityManager)
    {
        // Si la dateRetour est dépassée, supprimer l'entité
        if ($this->dateResaFin !== null && $this->dateResaFin < new \DateTime()) {
            $entityManager->remove($this);
            $entityManager->flush();
        }
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
