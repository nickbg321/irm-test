<?php

namespace App\Exceptions;

use Exception;

class ProviderException extends Exception
{
    const INVALID_JSON = 1;

    public static function invalidJson(): self
    {
        return new self('Invalid JSON pricing list.', self::INVALID_JSON);
    }
}
