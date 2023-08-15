<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PositionRepository::class)
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $namePosition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePosition(): ?string
    {
        return $this->namePosition;
    }

    public function setNamePosition(string $namePosition): self
    {
        $this->namePosition = $namePosition;

        return $this;
    }
}
