<?php

declare(strict_types=1);

namespace Fever\Domain;

abstract class AggregateRoot
{
    /**
     * @var int
     */
    protected $version = 0;

    /**
     * @var DomainEvent[]
     */
    protected $recordedEvents = [];

    protected function recordThat(DomainEvent $event): void
    {
        $this->version += 1;

        $this->recordedEvents[] = $event;
    }

    public function recordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function emptyRecordedEvents(): void
    {
        $this->recordedEvents = [];
    }

    protected function version(): int
    {
        return $this->version;
    }
}
