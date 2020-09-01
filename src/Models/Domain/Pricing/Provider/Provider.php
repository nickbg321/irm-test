<?php

namespace App\Models\Domain\Pricing\Provider;

use App\Models\Domain\Pricing\PricingList;

interface Provider
{
    /**
     * Returns a pricing list containing products and their prices.
     *
     * @return PricingList
     */
    public function getPricingList(): PricingList;
}
