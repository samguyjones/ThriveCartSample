<?php
namespace Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'charge')]

class Charge
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'float')]
    private float $threshold;

    #[ORM\Column(type: 'float')]
    private float $charge;

    public function getId(): int
    {
        return $this->id;
    }

    public function getThreshold(): float
    {
        return $this->threshold;
    }

    public function setThreshold(float $threshold): void
    {
        $this->threshold = $threshold;
    }

    public function getCharge(): float
    {
        return $this->charge;
    }

    public function setCharge(float $charge): void
    {
        $this->charge = $charge;
    }
}