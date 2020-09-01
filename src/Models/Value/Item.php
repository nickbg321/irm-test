<?php

namespace App\Models\Value;

use App\Exceptions\ItemException;

class Item
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $bulkPrice;

    /**
     * @var int
     */
    private $bulkAmount;

    /**
     * Item constructor.
     *
     * @param string $code
     * @param float $price
     * @param float $bulkPrice
     * @param float $bulkAmount
     * @throws ItemException
     */
    public function __construct(string $code, float $price, float $bulkPrice, float $bulkAmount) {
        if ($price < 0) {
            throw ItemException::invalidPrice();
        }

        if ($bulkPrice < 0) {
            throw ItemException::invalidBulkPrice();
        }

        if ($bulkAmount < 0) {
            throw ItemException::invalidBulkAmount();
        }

        $this->code = $code;
        $this->price = $price;
        $this->bulkPrice = $bulkPrice;
        $this->bulkAmount = $bulkAmount;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getBulkPrice(): float
    {
        return $this->bulkPrice;
    }

    /**
     * @return int
     */
    public function getBulkAmount(): int
    {
        return $this->bulkAmount;
    }

    /**
     * Checks if the item is applicable for a bulk discount.
     *
     * @return bool
     */
    public function hasBulkDiscount(): bool
    {
        return $this->bulkAmount && $this->bulkPrice;
    }
}
