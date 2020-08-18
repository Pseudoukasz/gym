<?php

namespace App\Entity;

use App\Repository\ZajeciaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZajeciaRepository::class)
 */
class Zajecia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Trener::class, inversedBy="zajecia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idTrener;

    /**
     * @ORM\ManyToOne(targetEntity=Sale::class, inversedBy="zajeciasala")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Sala;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nazwa;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datazak;

    /**
     * @ORM\OneToMany(targetEntity=ZapisyNaZajecia::class, mappedBy="zajecia")
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

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getIdTrener(): ?Trener
    {
        return $this->idTrener;
    }

    public function setIdTrener(?Trener $idTrener): self
    {
        $this->idTrener = $idTrener;

        return $this;
    }

    public function getSala(): ?Sale
    {
        return $this->Sala;
    }

    public function setSala(?Sale $Sala): self
    {
        $this->Sala = $Sala;

        return $this;
    }

    public function getNazwa(): ?string
    {
        return $this->Nazwa;
    }

    public function setNazwa(string $Nazwa): self
    {
        $this->Nazwa = $Nazwa;

        return $this;
    }

    public function getDatazak(): ?\DateTimeInterface
    {
        return $this->datazak;
    }

    public function setDatazak(\DateTimeInterface $datazak): self
    {
        $this->datazak = $datazak;

        return $this;
    }

    /**
     * @return Collection|ZapisyNaZajecia[]
     */
    public function getZajecia(): Collection
    {
        return $this->zajecia;
    }

    public function addZajecium(ZapisyNaZajecia $zajecium): self
    {
        if (!$this->zajecia->contains($zajecium)) {
            $this->zajecia[] = $zajecium;
            $zajecium->setZajecia($this);
        }

        return $this;
    }

    public function removeZajecium(ZapisyNaZajecia $zajecium): self
    {
        if ($this->zajecia->contains($zajecium)) {
            $this->zajecia->removeElement($zajecium);
            // set the owning side to null (unless already changed)
            if ($zajecium->getZajecia() === $this) {
                $zajecium->setZajecia(null);
            }
        }

        return $this;
    }
}
