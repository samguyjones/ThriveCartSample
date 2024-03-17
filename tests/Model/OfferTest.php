<?php
namespace Model;

final class OfferTest extends AbstractTest
{
    public function testOfferLogic(): void
    {
        $offer = new Offer();
        $offer->setCode('RedBogh');
        $logic = $offer->getLogic();
        $this->assertEquals('Model\Offer\RedBogh', get_class($logic));
    }
}