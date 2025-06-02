<?php

declare(strict_types=1);

namespace Fever\Application\Query;

class SearchEventsQueryHandler implements QueryHandler
{
    /**
     * @var EventFinder
     */
    private $eventFinder;

    public function __construct(EventFinder $eventFinder)
    {
        $this->eventFinder = $eventFinder;
    }

    /**
     * @param SearchEventsQuery $query
     */
    public function handle(Query $query): array
    {
        return $this->eventFinder->search($query->startsAt(), $query->endsAt());
    }
}
