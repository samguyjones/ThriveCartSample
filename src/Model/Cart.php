<?php
namespace Model;

class Cart {

    private array $purchases;
    private EntityManager $em;

    public function __construct() {
        $this->purchases = [];
    }

    /**
     * Adds a product with an optional quantity to the cart.
     */
    public function addPurchase(Product $product, int $quantity = 1): void
    {
        $code = $product->getCode();
        if (isset($this->purchases[$code])) {
            $this->purchases[$code]->addQuantity($quantity);
        } else {
            $this->purchases[$code] = new Purchase($product, $quantity);
        }
    }

    /**
     * Returns cost of all purchases before offset or charge
     */
    public function getSubTotal(): float
    {
        return round(array_reduce($this->purchases, fn($total, $purchase) => $total += $purchase->getPrice(), 0), 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Method that returns cost to customer.
     */
    public function getCost(): float
    {
        $basePrice = $this->getSubTotal() + $this->getOffset();
        return round($basePrice + $this->getCharge($basePrice), 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Grabs logic for all the offers for all products and totals all their applied results for fees or savings.
     */
    public function getOffset(): float
    {
        $logic = [];
        foreach ($this->getPurchases() as $purchase) {
            $logic = array_merge($logic, $purchase->getProduct()->getOfferLogic());
        }
        return array_reduce($logic, fn($total, $offerLogic) => $total += $offerLogic->getOfferValue($this, $logic), 0);
    }

    public function getPurchases(): array
    {
        return $this->purchases;
    }

    public function getPurchase(string $code): Purchase|null
    {
        if (!isset($this->purchases[$code])) {
            return null;
        }
        return $this->purchases[$code];
    }

    /**
     * Get the charge. If it needs to change a lot, you can query it from the charge table with something
     * like:
     * 
     * SELECT MIN(charge)
     * FROM charge
     * WHERE threshold < ?
     * 
     * If you want separate charges for separate things, you could move charges to the "offers" category.
     */
    public function getCharge(float $basePrice): float
    {
        if ($basePrice > 90) {
            return 0;
        }
        if ($basePrice > 50) {
            return 2.95;
        }
        return 4.95;
    }
}