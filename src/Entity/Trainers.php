<?php

namespace App\Entity;

use App\Repository\TrainersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainersRepository::class)
 */
class Trainers
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity=Classes::class, mappedBy="idTrainer")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection|Classes[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClasses(Classes $classes): self
    {
        if (!$this->classes->contains($classes)) {
            $this->classes[] = $classes;
            $classes->setTrainer($this);
        }

        return $this;
    }

    public function removeClasses(Classes $classes): self
    {
        if ($this->classes->contains($classes)) {
            $this->classes->removeElement($classes);
            // set the owning side to null (unless already changed)
            if ($classes->getTrainer() === $this) {
                $classes->setTrainer(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->surname;
    }
}
