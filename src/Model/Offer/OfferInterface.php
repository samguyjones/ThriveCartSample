<?php
namespace Model\Offer;

interface OfferInterface
{
    public function getOfferValue($cart, $offers): float;
}