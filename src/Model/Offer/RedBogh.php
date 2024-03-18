<?php
namespace Model\Offer;

class RedBogh implements OfferInterface
{
    public function getOfferValue($cart, $offers): float
    {
        $reds = $cart->getPurchase('R01');
        if (is_null($reds)) {
            return 0;
        }
        $secondOnes = floor($reds->getQuantity() / 2);
        $halfPrice = round($reds->getProduct()->getPrice() / 2, 2, PHP_ROUND_HALF_UP);
        return -$halfPrice * $secondOnes;
    }
}