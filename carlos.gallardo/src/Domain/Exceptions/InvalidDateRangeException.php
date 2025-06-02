<?php

declare(strict_types=1);

namespace Fever\Domain\Exceptions;

class InvalidDateRangeException extends \Exception
{
    public static function withInvalidStart(): self
    {
        return new self("Invalid start date, it cannot be greater than end date");
    }
}
