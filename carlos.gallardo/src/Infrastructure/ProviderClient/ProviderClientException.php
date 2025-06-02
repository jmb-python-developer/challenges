<?php

declare(strict_types=1);

namespace Fever\Infrastructure\ProviderClient;

class ProviderClientException extends \Exception
{
    public static function withUrlNotReachable(): self
    {
        return new self("The URL provided is not reachable so the content cannot be downloaded");
    }

    public static function withInvalidContent(): self
    {
        return new self("The content of the payload is not valid");
    }

    public static function withEncodingError(): self
    {
        return new self("The payload cannot be encoded to JSON");
    }
}
