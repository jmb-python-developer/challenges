<?php

declare(strict_types=1);


namespace tests\Application\Query;

use Fever\Application\Query\EventFinder;
use Fever\Application\Query\EventView;
use Fever\Application\Query\SearchEventsQuery;
use Fever\Application\Query\SearchEventsQueryHandler;
use PHPUnit\Framework\TestCase;
use Tests\Application\Stubs\EventFinderFoundStub;
use Tests\Application\Stubs\EventFinderNotFoundStub;

class SearchEventQueryHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFindEvents(): void
    {
        $startsAt = '2021-02-01';
        $endsAt = '2022-07-03';
        $eventFinder = new EventFinderFoundStub();
        $events = $this->queryHandler($eventFinder)->handle(new SearchEventsQuery($startsAt, $endsAt));

        foreach ($events as $event) {
            $this->assertInstanceOf(EventView::class, $event);
        }

        $this->assertCount(2, $events);
    }

    /**
     * @test
     */
    public function shouldNotFindEvents(): void
    {
        $eventFinder = new EventFinderNotFoundStub();
        $events = $this->QueryHandler($eventFinder)->handle(new SearchEventsQuery('any-date', 'any-date'));

        $this->assertEmpty($events);
    }

    private function queryHandler(EventFinder $eventFinder): SearchEventsQueryHandler
    {
        return new SearchEventsQueryHandler($eventFinder);
    }
}