<?php

namespace App\Entity;

use App\Repository\ZapisyNaZajeciaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZapisyNaZajeciaRepository::class)
 */
class ZapisyNaZajecia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="zajecia")
     */
    private $uzytkownik;

    /**
     * @ORM\ManyToOne(targetEntity=Zajecia::class, inversedBy="zajecia")
     */
    private $zajecia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUzytkownik(): ?User
    {
        return $this->uzytkownik;
    }

    public function setUzytkownik(?User $uzytkownik): self
    {
        $this->uzytkownik = $uzytkownik;

        return $this;
    }

    public function getZajecia(): ?Zajecia
    {
        return $this->zajecia;
    }

    public function setZajecia(?Zajecia $zajecia): self
    {
        $this->zajecia = $zajecia;

        return $this;
    }
}
