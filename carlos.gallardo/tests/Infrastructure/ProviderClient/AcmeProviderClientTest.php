<?php

declare(strict_types=1);

namespace Tests\Infrastructure\ProviderClient;

use Fever\Domain\EventId;
use Fever\Domain\Exceptions\InvalidEventIdException;
use Fever\Infrastructure\ProviderClient\AcmeProviderClient;
use Fever\Infrastructure\ProviderClient\EventDTO;
use Fever\Infrastructure\ProviderClient\ProviderClientException;
use PHPUnit\Framework\TestCase;

class AcmeProviderClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFetchEvents(): void
    {
        $client = new AcmeProviderClient(__DIR__ . '/data/default-response.xml');

        $events = (array) $client->events();
        $this->assertIsIterable($events);
        $this->assertCount(2, $events);
        /** @var EventDTO $firstEvent */
        $firstEvent = array_shift($events);

        $this->assertSame($firstEvent->providerEventId, "291");
        $this->assertSame($firstEvent->title, "Camela en concierto");
        $this->assertEquals($firstEvent->start, \DateTimeImmutable::createFromFormat(AcmeProviderClient::DATE_FORMAT, '2021-06-30T21:00:00'));
        $this->assertEquals($firstEvent->end, \DateTimeImmutable::createFromFormat(AcmeProviderClient::DATE_FORMAT, '2021-06-30T22:00:00'));
        $this->assertSame($firstEvent->minPrice, 15.00);
        $this->assertSame($firstEvent->maxPrice, 30.00);
    }

    /**
     * @test
     */
    public function shouldNotFetchEvents(): void
    {
        $client = new AcmeProviderClient(__DIR__ . '/data/empty-response.xml');

        $events = (array) $client->events();
        $this->assertIsIterable($events);
        $this->assertCount(0, $events);

        $client = new AcmeProviderClient(__DIR__ . '/data/only-offline-response.xml');

        $events = (array) $client->events();
        $this->assertIsIterable($events);
        $this->assertCount(0, $events);
    }

    /**
     * @test
     */
    public function shouldNotFetchEventsWithInvalidURL(): void
    {
        $client = new AcmeProviderClient(__DIR__ . '/data/non-existing.xml');
        $events = (array) $client->events();
        $this->assertIsIterable($events);
        $this->assertCount(0, $events);
    }

    /**
     * @test
     */
    public function shouldNotFetchEventsWithInvalidXML(): void
    {
        $client = new AcmeProviderClient(__DIR__ . '/data/invalid-response.xml');
        $events = (array) $client->events();
        $this->assertIsIterable($events);
        $this->assertCount(0, $events);
    }
}
