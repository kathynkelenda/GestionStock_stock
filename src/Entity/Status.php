<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nameStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameStatus(): ?string
    {
        return $this->nameStatus;
    }

    public function setNameStatus(string $nameStatus): self
    {
        $this->nameStatus = $nameStatus;

        return $this;
    }
}
