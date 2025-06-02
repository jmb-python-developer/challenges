<?php

declare(strict_types=1);

namespace Tests\Domain;

use Fever\Domain\EventId;
use Fever\Domain\Exceptions\InvalidEventIdException;
use PHPUnit\Framework\TestCase;

class EventIdTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateUnique(): void
    {
        $eventId = EventId::unique();

        $this->assertIsString($eventId->id());
    }

    /**
     * @test
     */
    public function shouldCreateFromExisting(): void
    {
        $id = 'this-is-an-existing-id';
        $eventId = EventId::fromExisting('this-is-an-existing-id');

        $this->assertSame($eventId->id(), $id);
    }

    /**
     * @test
     */
    public function shouldFailCreatingFromExisting(): void
    {
        $this->expectException(InvalidEventIdException::class);
        EventId::fromExisting('');
    }
}
