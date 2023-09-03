<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields = {"email"},
 * message = "L'email entrée est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=2,minMessage="Veuillez ressaisir votre nom")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min=8,minMessage="Votre mot de passe doit faire au minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Vous n'avez pas saisi le même mot de passe")
     */
    public $confirmPassword; 


    

    /**
     * @ORM\ManyToOne(targetEntity=Position::class)
     */
    private $To_occupy;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="users")
     */
    private $To_manage;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $prenom;

    

    public function __construct()
    {
        $this->To_manage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->password = $confirmPassword;

        return $this;
    }

    public function getRoles(): array
    {
        $roles=$this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    public function getToOccupy(): ?Position
    {
        return $this->To_occupy;
    }

    public function setToOccupy(?Position $To_occupy): self
    {
        $this->To_occupy = $To_occupy;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getToManage(): Collection
    {
        return $this->To_manage;
    }

    public function addToManage(Product $toManage): self
    {
        if (!$this->To_manage->contains($toManage)) {
            $this->To_manage[] = $toManage;
        }

        return $this;
    }

    public function removeToManage(Product $toManage): self
    {
        $this->To_manage->removeElement($toManage);

        return $this;
    }

    public function eraseCredentials(){}

    public function getSalt(){}

    
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    
    
    
    

}
