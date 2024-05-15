<?php

namespace App\Entity;

use App\Repository\DisponibiliteRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisponibiliteRepository::class)]
class Disponibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "Veuillez renseigner une date de début.")]
    #[Assert\type("DateTime", message: "Veuillez entrer une date de début dans un format valide exemple: 01/06/2024")]
    #[Assert\LessThan(propertyPath:"date_fin", message:"La date de début doit être antèrieure a la date de fin.")]
    #[Assert\GreaterThan("today", message:"La date de début doit être ultèrieure a aujourd'hui.")]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "Veuillez renseigner une date de fin")]
    #[Assert\Type("DateTime", message: "Veuillez entrer une date de fin dans un format valide exemple: 01/06/2024")]
    #[Assert\GreaterThan(propertyPath:"date_debut", message:"La date de fin doit être ultèrieure a la date de début.")]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez renseigner un prix de de location par jour.")]
    #[Assert\Positive(message: "Le prix doit être supérieur a 0.")]
    private ?int $prix_jour = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\ManyToOne(inversedBy: 'disponibilite')]
    private ?Vehicule $vehicule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getPrixJour(): ?int
    {
        return $this->prix_jour;
    }

    public function setPrixJour(int $prix_jour): static
    {
        $this->prix_jour = $prix_jour;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): static
    {
        $this->vehicule = $vehicule;

        return $this;
    }
}
