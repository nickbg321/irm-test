<?php

namespace App\Models\Domain\Pricing\Provider;

use App\Exceptions\ItemException;
use App\Exceptions\ProviderException;
use App\Models\Domain\Pricing\PricingList;
use App\Models\Value\Item;

class JsonProvider implements Provider
{
    /**
     * @var PricingList
     */
    private $pricingList;

    /**
     * JsonProvider constructor.
     *
     * @param string $filepath
     * @throws ItemException
     * @throws ProviderException
     */
    public function __construct(string $filepath)
    {
        $this->pricingList = new PricingList();
        $this->loadPricing($filepath);
    }

    /**
     * Path to the JSON file containing the pricing of the products.
     *
     * @param string $filepath
     * @throws ItemException
     * @throws ProviderException
     */
    private function loadPricing(string $filepath): void
    {
        $pricing = json_decode(file_get_contents($filepath), true);

        if (!$pricing) {
            throw ProviderException::invalidJson();
        }

        foreach ($pricing as $row) {
            $item = new Item($row['code'], $row['price'], $row['bulk_price'], $row['bulk_amount']);
            $this->pricingList->addItem($item);
        }
    }

    /**
     * @return PricingList
     */
    public function getPricingList(): PricingList
    {
        return $this->pricingList;
    }
}
