<?php

namespace App\Entity;

use App\Repository\TrenerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrenerRepository::class)
 */
class Trener
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Imie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nazwisko;

    /**
     * @ORM\OneToMany(targetEntity=Zajecia::class, mappedBy="idTrener")
     */
    private $zajecia;

    public function __construct()
    {
        $this->zajecia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImie(): ?string
    {
        return $this->Imie;
    }

    public function setImie(string $Imie): self
    {
        $this->Imie = $Imie;

        return $this;
    }

    public function getNazwisko(): ?string
    {
        return $this->Nazwisko;
    }

    public function setNazwisko(string $Nazwisko): self
    {
        $this->Nazwisko = $Nazwisko;

        return $this;
    }

    /**
     * @return Collection|Zajecia[]
     */
    public function getZajecia(): Collection
    {
        return $this->zajecia;
    }

    public function addZajecium(Zajecia $zajecium): self
    {
        if (!$this->zajecia->contains($zajecium)) {
            $this->zajecia[] = $zajecium;
            $zajecium->setIdTrener($this);
        }

        return $this;
    }

    public function removeZajecium(Zajecia $zajecium): self
    {
        if ($this->zajecia->contains($zajecium)) {
            $this->zajecia->removeElement($zajecium);
            // set the owning side to null (unless already changed)
            if ($zajecium->getIdTrener() === $this) {
                $zajecium->setIdTrener(null);
            }
        }

        return $this;
    }
}
