<?php

declare(strict_types=1);

namespace Fever\Domain\EventsEvent;

use DateTimeImmutable;
use Fever\Domain\DomainEvent;

class EventCreated implements DomainEvent
{
    private const DEFAULT_DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $providerEventId;

    /**
     * @var string
     */
    private $companyId;

    /**
     * @var DateTimeImmutable
     */
    private $start;

    /**
     * @var DateTimeImmutable
     */
    private $end;

    /**
     * @var float
     */
    private $minPrice;

    /**
     * @var float
     */
    private $maxPrice;

    public function __construct(
        string $id,
        string $title,
        string $providerEventId,
        string $companyId,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        float $minPrice,
        float $maxPrice
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->providerEventId = $providerEventId;
        $this->companyId = $companyId;
        $this->start = $start;
        $this->end = $end;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'provider_event_id' => $this->providerEventId,
            'company_id' => $this->companyId,
            'start' => $this->start->format(self::DEFAULT_DATE_FORMAT),
            'end' => $this->end->format(self::DEFAULT_DATE_FORMAT),
            'min_price' => $this->minPrice,
            'max_price' => $this->maxPrice,
        ];
    }
}
