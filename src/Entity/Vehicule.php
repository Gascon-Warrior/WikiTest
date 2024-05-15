<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le champ marque doit être renseigné')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Le champ marque doit faire {{ limit }} caractères minimum.',
        maxMessage: 'Le champ marque doit faire {{ limit }} caractères maximum.'
    )]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le champ modèle doit être renseigné')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Le champ modèle doit faire {{ limit }} caractères minimum.',
        maxMessage: 'Le champ modèle doit faire {{ limit }} caractères maximum.'
    )]
    private ?string $modele = null;

    /**
     * @var Collection<int, Disponibilite>
     */
    #[ORM\OneToMany(targetEntity: Disponibilite::class, mappedBy: 'vehicule', cascade: ['remove'])]
    private Collection $disponibilite;

    public function __construct()
    {
        $this->disponibilite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * @return Collection<int, Disponibilite>
     */
    public function getDisponibilite(): Collection
    {
        return $this->disponibilite;
    }

    public function addDisponibilite(Disponibilite $disponibilite): static
    {
        if (!$this->disponibilite->contains($disponibilite)) {
            $this->disponibilite->add($disponibilite);
            $disponibilite->setVehicule($this);
        }

        return $this;
    }

    public function removeDisponibilite(Disponibilite $disponibilite): static
    {
        if ($this->disponibilite->removeElement($disponibilite)) {
            // set the owning side to null (unless already changed)
            if ($disponibilite->getVehicule() === $this) {
                $disponibilite->setVehicule(null);
            }
        }

        return $this;
    }
}
