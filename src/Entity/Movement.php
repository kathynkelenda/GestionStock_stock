<?php

namespace App\Entity;

use App\Repository\MovementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovementRepository::class)
 */
class Movement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfMovement;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityMovement;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="To_be")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="movements")
     */
    private $To_know;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfMovement(): ?\DateTimeInterface
    {
        return $this->dateOfMovement;
    }

    public function setDateOfMovement(\DateTimeInterface $dateOfMovement): self
    {
        $this->dateOfMovement = $dateOfMovement;

        return $this;
    }

    public function getQuantityMovement(): ?int
    {
        return $this->quantityMovement;
    }

    public function setQuantityMovement(int $quantityMovement): self
    {
        $this->quantityMovement = $quantityMovement;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getToKnow(): ?Product
    {
        return $this->To_know;
    }

    public function setToKnow(?Product $To_know): self
    {
        $this->To_know = $To_know;

        return $this;
    }

    
}
