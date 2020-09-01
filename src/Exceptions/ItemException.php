<?php

namespace App\Exceptions;

use Exception;

class ItemException extends Exception
{
    const INVALID_PRICE = 1;
    const INVALID_BULK_PRICE = 2;
    const INVALID_BULK_AMOUNT = 3;

    public static function invalidPrice(): self
    {
        return new self('Item price cannot be negative.', self::INVALID_PRICE);
    }

    public static function invalidBulkPrice(): self
    {
        return new self('Item bulk price cannot be negative.', self::INVALID_BULK_PRICE);
    }

    public static function invalidBulkAmount(): self
    {
        return new self('Item bulk amount cannot be negative.', self::INVALID_BULK_AMOUNT);
    }
}
