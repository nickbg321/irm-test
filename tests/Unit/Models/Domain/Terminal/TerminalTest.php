<?php

namespace Tests\Unit\Models\Domain\Terminal;

use App\Models\Domain\Pricing\PricingList;
use App\Models\Domain\Pricing\Provider\Provider;
use App\Models\Domain\Terminal\Terminal;
use App\Models\Value\Item;
use PHPUnit\Framework\TestCase;

class TerminalTest extends TestCase
{
    public function testTotalIsCorrectlyCalculatedInOrder1()
    {
        $terminal = new Terminal();
        $terminal->setPricing($this->getProviderMock());
        $terminal->scanItem('ZA');
        $terminal->scanItem('YB');
        $terminal->scanItem('FC');
        $terminal->scanItem('GD');
        $terminal->scanItem('ZA');
        $terminal->scanItem('YB');
        $terminal->scanItem('ZA');
        $terminal->scanItem('ZA');

        $this->assertEquals(32.4, $terminal->getTotal());
    }

    public function testTotalIsCorrectlyCalculatedInOrder2()
    {
        $terminal = new Terminal();
        $terminal->setPricing($this->getProviderMock());
        $terminal->scanItem('FC');
        $terminal->scanItem('FC');
        $terminal->scanItem('FC');
        $terminal->scanItem('FC');
        $terminal->scanItem('FC');
        $terminal->scanItem('FC');
        $terminal->scanItem('FC');

        $this->assertEquals(7.25, $terminal->getTotal());
    }

    public function testTotalIsCorrectlyCalculatedInOrder3()
    {
        $terminal = new Terminal();
        $terminal->setPricing($this->getProviderMock());
        $terminal->scanItem('ZA');
        $terminal->scanItem('YB');
        $terminal->scanItem('FC');
        $terminal->scanItem('GD');

        $this->assertEquals(15.4, $terminal->getTotal());
    }

    private function getProviderMock(): Provider
    {
        $mock = $this->createMock(Provider::class);
        $mock->method('getPricingList')
            ->willReturn($this->getPricingListMock());

        return $mock;
    }

    private function getPricingListMock()
    {
        $mock = $this->createMock(PricingList::class);
        $mock->method('getItem')
            ->with($this->anything())
            ->will($this->returnCallback(function ($code) {
                switch ($code) {
                    case 'ZA':
                        return $this->getItemMock('ZA', 2, 7, 4);
                    case 'YB':
                        return $this->getItemMock('YB', 12, 0, 0);
                    case 'FC':
                        return $this->getItemMock('FC', 1.25, 6, 6);
                    case 'GD':
                        return $this->getItemMock('GD', 0.15, 0, 0);
                }
            }));

        return $mock;
    }

    private function getItemMock(string $code, float $price, float $bulkPrice, int $bulkAmount)
    {
        $mock = $this->createMock(Item::class);
        $mock->method('getCode')
            ->willReturn($code);
        $mock->method('getPrice')
            ->willReturn($price);
        $mock->method('getBulkPrice')
            ->willReturn($bulkPrice);
        $mock->method('getBulkAmount')
            ->willReturn($bulkAmount);
        $mock->method('hasBulkDiscount')
            ->willReturn($bulkAmount && $bulkPrice);

        return $mock;
    }
}
