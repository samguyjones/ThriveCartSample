<?php
namespace Model;

class Purchase {
    private Product $product;
    private int $quantity;

    public function __construct(product $product, int $quantity) {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getPrice(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }

    public function getProduct(): product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function addQuantity($quantity)
    {
        $this->quantity += $quantity;
    }
}