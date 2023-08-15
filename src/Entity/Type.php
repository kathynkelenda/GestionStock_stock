<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $nameType;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="type")
     */
    private $To_be;

    public function __construct()
    {
        $this->To_be = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameType(): ?string
    {
        return $this->nameType;
    }

    public function setNameType(string $nameType): self
    {
        $this->nameType = $nameType;

        return $this;
    }

    /**
     * @return Collection<int, Movement>
     */
    public function getToBe(): Collection
    {
        return $this->To_be;
    }

    public function addToBe(Movement $toBe): self
    {
        if (!$this->To_be->contains($toBe)) {
            $this->To_be[] = $toBe;
            $toBe->setType($this);
        }

        return $this;
    }

    public function removeToBe(Movement $toBe): self
    {
        if ($this->To_be->removeElement($toBe)) {
            // set the owning side to null (unless already changed)
            if ($toBe->getType() === $this) {
                $toBe->setType(null);
            }
        }

        return $this;
    }

    
}
