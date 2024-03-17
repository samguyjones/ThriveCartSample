<?php
namespace Model;
use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    public function mockProduct($code, $price, $offerLogic = null)
    {
      $product = $this->createStub(Product::class);
      $product->method('getCode')
        ->willReturn($code);
      $product->method('getPrice')
        ->willReturn($price);
      if (!is_null($offerLogic)) {
        $product->method('getOfferLogic')
          ->willReturn([$offerLogic]);
      } else {
        $product->method('getOfferLogic')
          ->willReturn([]);
      }
      return $product;
    }

    public function makeCart($numberRed = 0, $numberGreen = 0, $numberBlue = 0, $offerLogic = null): Cart
    {
      $cart = new Cart();
      $red = $this->mockProduct('R01', 32.95, $offerLogic);
      $green = $this->mockProduct('G01', 24.95);
      $blue = $this->mockProduct('B01', 7.95);
      $cart->addPurchase($red, $numberRed);
      $cart->addPurchase($green, $numberGreen);
      $cart->addPurchase($blue, $numberBlue);
      return $cart;
    }
}