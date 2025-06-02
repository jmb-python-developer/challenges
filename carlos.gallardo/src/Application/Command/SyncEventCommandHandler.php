<?php

declare(strict_types=1);

namespace Fever\Application\Command;

use Fever\Domain\DateRange;
use Fever\Domain\Event;
use Fever\Domain\EventRepository;
use Fever\Domain\Exceptions\EmptyTitleForEventException;
use Fever\Domain\Exceptions\InvalidDateRangeException;
use Fever\Domain\Exceptions\InvalidPriceRangeException;
use Fever\Domain\PriceRange;

class SyncEventCommandHandler implements CommandHandler
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param SyncEventCommand $command
     * @throws InvalidDateRangeException
     * @throws InvalidPriceRangeException
     * @throws EmptyTitleForEventException
     */
    public function handle(Command $command)
    {
        $event = Event::create(
            $command->title(),
            DateRange::create($command->start(), $command->end()),
            PriceRange::create($command->minPrice(), $command->maxPrice()),
            $command->providerEventId(),
            $command->companyId()
        );

        $this->eventRepository->save($event);
    }
}
