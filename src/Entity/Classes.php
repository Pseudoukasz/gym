<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassesRepository::class)
 */
class Classes
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
    private $date_start;

    /**
     * @ORM\ManyToOne(targetEntity=Trainers::class, inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Trainer;

    /**
     * @ORM\ManyToOne(targetEntity=Rooms::class, inversedBy="classedId")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_end;

    /**
     * @ORM\OneToMany(targetEntity=SignForClasses::class, mappedBy="Classes")
     */
    private $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getTrainer(): ?Trainers
    {
        return $this->Trainer;
    }

    public function setTrainer(?Trainers $Trainer): self
    {
        $this->Trainer = $Trainer;

        return $this;
    }

    public function getRoom(): ?Rooms
    {
        return $this->room;
    }

    public function setRoom(?Rooms $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * @return Collection|SignForClasses[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClasses(SignForClasses $classes): self
    {
        if (!$this->classes->contains($classes)) {
            $this->classes[] = $classes;
            $classes->setClasses($this);
        }

        return $this;
    }

    public function removeClasses(SignForClasses $classes): self
    {
        if ($this->classes->contains($classes)) {
            $this->classes->removeElement($classes);
            // set the owning side to null (unless already changed)
            if ($classes->getClasses() === $this) {
                $classes->setClasses(null);
            }
        }

        return $this;
    }
}
