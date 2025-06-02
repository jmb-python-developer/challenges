<?php

declare(strict_types=1);

namespace Fever\Domain;

use Fever\Domain\Exceptions\InvalidEventIdException;
use Fever\Domain\Exceptions\InvalidEmployeeIdException;
use Ramsey\Uuid\Uuid;

final class EventId
{
    /**
     * @var string
     */
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @throws InvalidEventIdException
     */
    public static function fromExisting(string $id): self
    {
        if (empty($id)) {
            throw InvalidEventIdException::withId($id);
        }
        return new self($id);
    }

    public static function unique(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function id(): string
    {
        return $this->id;
    }
}