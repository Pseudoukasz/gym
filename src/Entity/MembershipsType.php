<?php

namespace App\Entity;

use App\Repository\MembershipsTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembershipsTypeRepository::class)
 */
class MembershipsType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Memberships::class, mappedBy="membershipsType")
     */
    private $membership;

    public function __construct()
    {
        $this->membership = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Memberships[]
     */
    public function getMembership(): Collection
    {
        return $this->membership;
    }

    public function addMembership(Memberships $membership): self
    {
        if (!$this->membership->contains($membership)) {
            $this->membership[] = $membership;
            $membership->setMembershipsType($this);
        }

        return $this;
    }

    public function removeMembership(Memberships $membership): self
    {
        if ($this->membership->contains($membership)) {
            $this->membership->removeElement($membership);
            // set the owning side to null (unless already changed)
            if ($membership->getMembershipsType() === $this) {
                $membership->setMembershipsType(null);
            }
        }

        return $this;
    }
}
