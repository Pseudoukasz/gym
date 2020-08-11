<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaleRepository::class)
 */
class Sale
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
    private $nazwa;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_uzytkownikow;

    /**
     * @ORM\OneToMany(targetEntity=Zajecia::class, mappedBy="Sala")
     */
    private $zajeciasala;

    public function __construct()
    {
        $this->zajeciasala = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getMaxUzytkownikow(): ?int
    {
        return $this->max_uzytkownikow;
    }

    public function setMaxUzytkownikow(int $max_uzytkownikow): self
    {
        $this->max_uzytkownikow = $max_uzytkownikow;

        return $this;
    }

    /**
     * @return Collection|Zajecia[]
     */
    public function getZajeciasala(): Collection
    {
        return $this->zajeciasala;
    }

    public function addZajeciasala(Zajecia $zajeciasala): self
    {
        if (!$this->zajeciasala->contains($zajeciasala)) {
            $this->zajeciasala[] = $zajeciasala;
            $zajeciasala->setSala($this);
        }

        return $this;
    }

    public function removeZajeciasala(Zajecia $zajeciasala): self
    {
        if ($this->zajeciasala->contains($zajeciasala)) {
            $this->zajeciasala->removeElement($zajeciasala);
            // set the owning side to null (unless already changed)
            if ($zajeciasala->getSala() === $this) {
                $zajeciasala->setSala(null);
            }
        }

        return $this;
    }
}
