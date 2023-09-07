<?php

namespace App\Entity;

use App\Repository\PasswordUpdateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PasswordUpdateRepository::class)
 */
class PasswordUpdate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $newPassword;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $confirmNewPassword;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $oldPassword;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="passwordUpdate", cascade={"persist", "remove"})
     */
    private $To_update;

    

    
    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(?string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmNewPassword(): ?string
    {
        return $this->confirmNewPassword;
    }

    public function setConfirmNewPassword(?string $confirmNewPassword): self
    {
        $this->confirmNewPassword = $confirmNewPassword;

        return $this;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(?string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getToUpdate(): ?User
    {
        return $this->To_update;
    }

    public function setToUpdate(?User $To_update): self
    {
        $this->To_update = $To_update;

        return $this;
    }


    
}
