<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NatureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=NatureRepository::class)
 * @UniqueEntity(
 *  fields = {"nameNature"},
 *  message = "Cette nature existe déjà!"
 * )
 */
class Nature
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
    private $nameNature;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="To_possess")
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    private $To_belong;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameNature(): ?string
    {
        return $this->nameNature;
    }

    public function setNameNature(string $nameNature): self
    {
        $this->nameNature = $nameNature;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setToPossess($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getToPossess() === $this) {
                $product->setToPossess(null);
            }
        }

        return $this;
    }

    public function getToBelong(): ?Category
    {
        return $this->To_belong;
    }

    public function setToBelong(?Category $To_belong): self
    {
        $this->To_belong = $To_belong;

        return $this;
    }
}

