<?php

declare(strict_types=1);

namespace Fever\Domain\Exceptions;

class InvalidEventIdException extends \Exception
{
    public static function withId(string $id): self
    {
        return new self("Event ID provided is not valid.");
    }
}
