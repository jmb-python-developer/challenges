<?php

declare(strict_types=1);

namespace Fever\Domain\Exceptions;

class InvalidPriceRangeException extends \Exception
{
    public static function withInvalidMinPrice(): self
    {
        return new self("Invalid min price, it cannot be greater than max price");
    }
}
