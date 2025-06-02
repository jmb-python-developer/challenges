<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence;

use Fever\Domain\Event;
use Fever\Domain\EventRepository;

class InMemoryEventRepository implements EventRepository
{
    /**
     * @var array
     */
    private $events = [];

    public function save(Event $event): void
    {
        $this->events[] = $event;
    }

    public function events(): array
    {
        return $this->events;
    }
}
