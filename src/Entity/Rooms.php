<?php

namespace App\Entity;

use App\Repository\RoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomsRepository::class)
 */
class Rooms
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
     * @ORM\Column(type="integer")
     */
    private $maxNumberOfUsers;

    /**
     * @ORM\OneToMany(targetEntity=Classes::class, mappedBy="Rooms")
     */
    private $classesId;

    public function __construct()
    {
        $this->classesId = new ArrayCollection();
    }



    /**
     * @return Collection|Classes[]
     */
    public function getClassesId(): Collection
    {
        return $this->classesId;
    }

    public function addClassesId(Classes $classesId): self
    {
        if (!$this->classesId->contains($this->classesId)) {
            $this->classesId[] = $this->classesId;
            $this->classesId->setSala($this);
        }

        return $this;
    }

    public function removeClassesId(Classes $classesId): self
    {
        if ($this->classesId->contains($classesId)) {
            $this->classesId->removeElement($classesId);
            // set the owning side to null (unless already changed)
            if ($classesId->getRoom() === $this) {
                $classesId->setRoom(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getMaxNumberOfUsers()
    {
        return $this->maxNumberOfUsers;
    }

    /**
     * @param mixed $maxNumberOfUsers
     */
    public function setMaxNumberOfUsers($maxNumberOfUsers): void
    {
        $this->maxNumberOfUsers = $maxNumberOfUsers;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}
