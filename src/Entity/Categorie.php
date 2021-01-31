<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Cadeau::class, mappedBy="categorie")
     */
    private $cadeaux;

    public function __construct()
    {
        $this->cadeaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Cadeau[]
     */
    public function getCadeaux(): Collection
    {
        return $this->cadeaux;
    }

    public function addCadeaux(Cadeau $cadeaux): self
    {
        if (!$this->cadeaux->contains($cadeaux)) {
            $this->cadeaux[] = $cadeaux;
            $cadeaux->setCategorie($this);
        }

        return $this;
    }

    public function removeCadeaux(Cadeau $cadeaux): self
    {
        if ($this->cadeaux->removeElement($cadeaux)) {
            // set the owning side to null (unless already changed)
            if ($cadeaux->getCategorie() === $this) {
                $cadeaux->setCategorie(null);
            }
        }

        return $this;
    }

    public function calculPrixMoy()
    {
        $som = 0;
        foreach($this->getCadeaux() as $cadeau){
            $som += $cadeau->getPrixMoyen();
        }

        return $som/$this->getCadeaux()->count(); 
    } 
}
