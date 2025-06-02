<?php

declare(strict_types=1);

namespace Tests\Application\Stubs;

use Fever\Application\Query\EventFinder;
use Fever\Application\Query\EventView;

class EventFinderFoundStub implements EventFinder
{
    public function search(string $startsAt, string $endsAt): array
    {
        return [
            new EventView('1234', 'title 1', '2021-04-25', '2021-04-25', '17:00', '19:00', 15, 35),
            new EventView('1235', 'title 2', '2021-08-12', '2021-08-13', '22:00', '23:00', 30, 45),
        ];
    }
}
