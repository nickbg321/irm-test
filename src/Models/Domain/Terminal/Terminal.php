<?php

namespace App\Models\Domain\Terminal;

use App\Exceptions\PricingListException;
use App\Models\Domain\Pricing\PricingList;
use App\Models\Domain\Pricing\Provider\Provider;

class Terminal
{
    /**
     * @var PricingList
     */
    private $pricingList;

    /**
     * An array containing order items and their amounts.
     *
     * @var array
     */
    private $order = [];

    /**
     * Sets the pricing list for the terminal using a pricing provider.
     *
     * @param Provider $pricingProvider
     * @return void
     */
    public function setPricing(Provider $pricingProvider): void
    {
        $this->pricingList = $pricingProvider->getPricingList();
    }

    /**
     * Adds an item to the order.
     *
     * @param string $code
     * @return void
     */
    public function scanItem(string $code): void
    {
        if (!isset($this->order[$code])) {
            $this->order[$code] = 0;
        }
        $this->order[$code]++;
    }

    /**
     * Calculates the final price of the order.
     *
     * @return float
     * @throws PricingListException
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->order as $code => $amount) {
            $item = $this->pricingList->getItem($code);

            if ($item->hasBulkDiscount()) {
                $bulkAmount = $item->getBulkAmount();
                $bulkPrice = $item->getBulkPrice();
                $bulks = floor($amount / $bulkAmount);

                if ($bulks >= 1) {
                    $total += $bulks * $bulkPrice;
                    $amount -= $bulks * $bulkAmount;
                }
            }

            $total += $item->getPrice() * $amount;
        }

        return $total;
    }
}
