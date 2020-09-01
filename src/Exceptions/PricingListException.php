<?php

namespace App\Exceptions;

use Exception;

class PricingListException extends Exception
{
    const MISSING_ITEM = 1;

    public static function missingItem(string $code): self
    {
        return new self('Item with code "' . $code . '" was not found in the pricing list.', self::MISSING_ITEM);
    }
}
