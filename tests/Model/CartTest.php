<?php
namespace Model;

final class CartTest extends AbstractTest
{
    public function testGetPurchases(): void
    {
        $cart = new Cart();
        $product = $this->mockProduct('R01', 4.25);
        $this->assertEquals('R01', $product->getCode());
        $cart->addPurchase($this->mockProduct('R01', 4.25), 2);
        $this->assertEquals(['R01'], array_keys($cart->getPurchases()));
    }

    public function testGetSubtotal(): void
    {
        $cart = $this->makeCart(1,3);
        $this->assertEquals(107.8, $cart->getSubTotal());
    }

    public function testGetCharge(): void
    {
        $cart = new Cart();
        $red = $this->mockProduct('R01', 32.95);
        $green = $this->mockProduct('G01', 24.95);
        $cart->addPurchase($red);
        $this->assertEquals(4.95, $cart->getCharge());
        $cart->addPurchase($green);
        $this->assertEquals(2.95, $cart->getCharge());
        $cart->addPurchase($green, 2);
        $this->assertEquals(0, $cart->getCharge());
    }

    public function testGetPurchase(): void
    {
        $cart = new Cart();
        $red = $this->mockProduct('R01', 32.95);
        $green = $this->mockProduct('G01', 24.95);
        $cart->addPurchase($red);
        $this->assertEquals($red, $cart->getPurchase('R01')->getProduct());
        $this->assertNull($cart->getPurchase('G01'));
        $cart->addPurchase($green);
        $this->assertEquals($green, $cart->getPurchase('G01')->getProduct());
    }

    public function testGetOffset(): void
    {
        $cart = $this->makeCart(3,1,1,new Offer\RedBogh());
        $this->assertEquals("Model\Offer\RedBogh", get_class($cart->getPurchase("R01")->getProduct()->getOfferLogic()[0]));
        $this->assertEquals(-16.47, $cart->getOffset());
    }

    public function testGetCost(): void
    {
        $cartOne = $this->makeCart(0,1,1);
        $this->assertEquals(37.85, $cartOne->getCost());
        $cartTwo = $this->makeCart(2,0,0, new Offer\RedBogh());
        $this->assertEquals(54.38, $cartTwo->getCost());
        $cartThree = $this->makeCart(1,1,0, new Offer\RedBogh());
        $this->assertEquals(60.85, $cartThree->getCost());
        $cartFour = $this->makeCart(3,0,2, new Offer\RedBogh());
        $this->assertEquals(98.27, $cartFour->getCost());
    }
}