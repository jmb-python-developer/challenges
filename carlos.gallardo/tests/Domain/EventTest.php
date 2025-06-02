<?php

declare(strict_types=1);

namespace Tests\Domain;

use Fever\Domain\DateRange;
use Fever\Domain\Event;
use Fever\Domain\PriceRange;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateSuccessfully(): void
    {
        $title = 'test-title';
        $eventDateRange = DateRange::create(
            new \DateTimeImmutable('now'),
            new \DateTimeImmutable('tomorrow')
        );

        $priceRange = PriceRange::create(100, 200);
        $providerEventId = "123";
        $companyId = "9";
        $event = Event::create($title, $eventDateRange, $priceRange, $providerEventId, $companyId);

        $this->assertSame($event->title(), $title);
        $this->assertIsString($event->id()->id());
        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame($event->providerEventId(), $providerEventId);
        $this->assertSame($event->companyId(), $companyId);
        $this->assertInstanceOf(DateRange::class, $event->eventDate());
        $this->assertInstanceOf(PriceRange::class, $event->priceRange());
    }
}
