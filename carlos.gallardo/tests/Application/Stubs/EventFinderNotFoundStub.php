<?php

declare(strict_types=1);

namespace Tests\Application\Stubs;

use Fever\Application\Query\EventFinder;
use Fever\Application\Query\EventView;

class EventFinderNotFoundStub implements EventFinder
{
    public function findByName(string $name): ?EventView
    {
        return null;
    }

    public function search(string $startsAt, string $endsAt): array
    {
        return [];
    }
}
