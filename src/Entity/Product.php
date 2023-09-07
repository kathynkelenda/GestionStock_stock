<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(min="3", minMessage="Votre article doit comporter au minimum 3 caractères")
     * 
     */
    private $nameProduct;

    /**
     * @ORM\Column(type="float", length=255)
     * @Assert\Positive
     */
    private $priceProduct;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive
     */
    private $vatProdut;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     * @Assert\Length(min="3", minMessage="Votre article doit comporter au minimum 3 caractères")
     */
    private $codeProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityProduct;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantityAlert;

   
    /**
     * @ORM\ManyToOne(targetEntity=Nature::class, inversedBy="products2")
     */
    public $To_possess;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="To_manage")
     */
    private $users;


    public function __construct()
    {
        
        $this->To_come_from = new ArrayCollection();
        $this->users = new ArrayCollection();
        
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduct(): ?string
    {
        return $this->nameProduct;
    }

    public function setNameProduct(string $nameProduct): self
    {
        $this->nameProduct = $nameProduct;

        return $this;
    }

    public function getPriceProduct(): ?float
    {
        return $this->priceProduct;
    }

    public function setPriceProduct(float $priceProduct): self
    {
        $this->priceProduct = $priceProduct;

        return $this;
    }

    public function getvatProdut(): ?float
    {
        return $this->vatProdut;
    }

    public function setvatProdut(?float $vatProdut): self
    {
        $this->vatProdut = $vatProdut;

        return $this;
    }

    public function getCodeProduct(): ?string
    {
        return $this->codeProduct;
    }

    public function setCodeProduct(?string $codeProduct): self
    {
        $this->codeProduct = $codeProduct;

        return $this;
    }

    public function getQuantityProduct(): ?int
    {
        return $this->quantityProduct;
    }

    public function setQuantityProduct(int $quantityProduct): self
    {
        $this->quantityProduct = $quantityProduct;

        return $this;
    }

    public function getQuantityAlert(): ?int
    {
        return $this->quantityAlert;
    }

    public function setQuantityAlert(?int $quantityAlert): self
    {
        $this->quantityAlert = $quantityAlert;

        return $this;
    }

   
    
    public function getToPossess(): ?Nature
    {
        return $this->To_possess;
    }

    public function setToPossess(?Nature $To_possess): self
    {
        $this->To_possess = $To_possess;

        return $this;
    }



    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addToManage($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeToManage($this);
        }

        return $this;
    }

}