<?php

declare(strict_types=1);

namespace Fever\Domain\Exceptions;

class EmptyTitleForEventException extends \Exception
{
    public static function create(): self
    {
        return new self("Event title cannot be empty.");
    }
}
