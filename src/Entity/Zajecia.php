<?php

namespace App\Entity;

use App\Repository\ZajeciaRepository;
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
}
