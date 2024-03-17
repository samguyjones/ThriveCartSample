<?php
namespace Model;

final class PurchaseTest extends AbstractTest
{
    public function testGetPrice(): void
    {
        $product = $this->mockProduct('R01', 1.50);
        $purchase = new Purchase($product, 3);
        $this->assertEquals(1.50, $product->getPrice());
        $this->assertEquals(4.50, $purchase->getPrice());
    }
}