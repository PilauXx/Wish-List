<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Adresse;


/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom_prenom;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sexe;

    /**
     * @ORM\ManyToMany(targetEntity=Cadeau::class, inversedBy="personnes")
     */
    private $souhaits;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_nais;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="personnes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    public function __construct()
    {
        $this->souhaits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nom_prenom;
    }

    public function setNomPrenom(string $nom_prenom): self
    {
        $this->nom_prenom = $nom_prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection|Cadeau[]
     */
    public function getSouhaits(): Collection
    {
        return $this->souhaits;
    }

    public function addSouhait(Cadeau $souhait): self
    {
        if (!$this->souhaits->contains($souhait)) {
            $this->souhaits[] = $souhait;
        }

        return $this;
    }

    public function removeSouhait(Cadeau $souhait): self
    {
        $this->souhaits->removeElement($souhait);

        return $this;
    }

    public function getDateNais(): ?\DateTimeInterface
    {
        return $this->date_nais;
    }

    public function setDateNais(\DateTimeInterface $date_nais): self
    {
        $this->date_nais = $date_nais;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAge(): int
    {
        $datetime1 = new \DateTime(); // date actuelle
        $age = date_diff($datetime1, $this->getDateNais())->y;

        return $age;
    }

}
