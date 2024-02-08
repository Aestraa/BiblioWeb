<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEmprunt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRetour = null;

    #[ORM\ManyToMany(targetEntity: Adherent::class, inversedBy: 'emprunts', fetch: 'LAZY')]
    private Collection $Relier;

    #[ORM\ManyToOne(inversedBy: 'emprunts', fetch: 'LAZY')]
    private ?Livre $Correspondre = null;

    public function __construct()
    {
        $this->Relier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeInterface $dateRetour): static
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    /**
     * @return Collection<int, Adherent>
     */
    public function getRelier(): Collection
    {
        return $this->Relier;
    }

    public function addRelier(Adherent $relier): static
    {
        if (!$this->Relier->contains($relier)) {
            $this->Relier->add($relier);
        }

        return $this;
    }

    public function removeRelier(Adherent $relier): static
    {
        $this->Relier->removeElement($relier);

        return $this;
    }

    public function getCorrespondre(): ?Livre
    {
        return $this->Correspondre;
    }

    public function setCorrespondre(?Livre $Correspondre): static
    {
        $this->Correspondre = $Correspondre;

        return $this;
    }

    // Définie dateEmprunt à la date d'aujourd'hui si aucune valeur n'est donnée ou null. 
    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->dateEmprunt = $this->dateEmprunt ?? new \DateTime();
    }
}
