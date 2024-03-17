<?php
namespace Model\Offer;

final class RedBoghTest extends \Model\AbstractTest
{
    public function testNoRedWidgets(): void
    {
        $cart = $this->makeCart(0,2);
        $redBogh = new RedBogh();
        $this->assertEquals(0, $redBogh->getOfferValue($cart, []));
    }

    public function testOneRedWidget(): void
    {
        $cart = $this->makeCart(1);
        $redBogh = new RedBogh();
        $this->assertEquals(0, $redBogh->getOfferValue($cart, []));
    }

    public function testThreeRedWidgets(): void
    {
        $cart = $this->makeCart(3);
        $redBogh = new RedBogh();
        $this->assertEquals(-16.47, $redBogh->getOfferValue($cart, []));
    }

    public function testFiveRedWidgets(): void
    {
        $cart = $this->makeCart(5);
        $redBogh = new RedBogh();
        $this->assertEquals(-32.94, $redBogh->getOfferValue($cart, []));
    }
}