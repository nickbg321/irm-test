<?php

namespace App\Models\Domain\Pricing;

use App\Exceptions\PricingListException;
use App\Models\Value\Item;

class PricingList
{
    /**
     * List of items in the pricing list indexed by their code.
     *
     * @var Item[]
     */
    private $list;

    /**
     * Adds an item to the pricing list.
     *
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        $this->list[$item->getCode()] = $item;
    }

    /**
     * Returns an item by a given code or throws an exception if the item is not found.
     *
     * @param string $code
     * @return Item
     * @throws PricingListException
     */
    public function getItem(string $code): Item
    {
        if (!isset($this->list[$code])) {
            throw PricingListException::missingItem($code);
        }

        return $this->list[$code];
    }
}
