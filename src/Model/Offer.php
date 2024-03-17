<?php
namespace Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Offer\OfferInterface as OfferInterface;

#[ORM\Entity]
#[ORM\Table(name: 'offer')]

class Offer
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'offers')]
    #[ORM\JoinTable(name: 'product_offer')]
    private Collection $products;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $code;

    public function getId(): int
    {
        return $this->id;
    }

    public function __construct() {
        $this->products = new ArrayCollection();
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

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getLogic(): mixed
    {
        if (!ctype_alnum($this->getCode())) {
            throw new \Exception(sprinf("Offer code '%s' for offer id %d has non-alphanumeric characters.", $this->getCode(), $this->getId()));
        }
        $classname = sprintf("Model\Offer\%s", $this->getCode());
        $offerLogic = new $classname();
        if (!$offerLogic instanceof \Model\Offer\OfferInterface) {
            throw new \Exception(sprintf("Offer class '%s' for offer id 2 does not implement OfferInterface.", $classname));
        }
        return $offerLogic;
    }
}