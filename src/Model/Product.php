<?php
namespace Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'product')]

class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\JoinTable(name: 'product_offer')]
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'products')]
    private Collection $offers;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(type: 'string')]
    private string $code;

    public function __construct() {
        $this->offers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice():float
    {
        return $this->price;
    }

    public function getOffers(): ArrayCollection
    {
        return $this->offers;
    }

    public function getOfferLogic(): array
    {
        return array_map(fn($offer) => $offer->getLogic(), $this->getOffers());
    }
}