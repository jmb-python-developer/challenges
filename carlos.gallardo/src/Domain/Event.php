<?php

declare(strict_types=1);

namespace Fever\Domain;

use Fever\Domain\Exceptions\EmptyTitleForEventException;

final class Event extends AggregateRoot
{
    /**
     * @var EventId
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
     * @var DateRange
     */
    private $eventDate;

    /**
     * @var PriceRange
     */
    private $priceRange;

    private function __construct(
        EventId $id,
        string $title,
        DateRange $eventDate,
        PriceRange $priceRange,
        string $providerEventId,
        string $companyId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->providerEventId = $providerEventId;
        $this->companyId = $companyId;
        $this->eventDate = $eventDate;
        $this->priceRange = $priceRange;
    }

    /**
     * @throws EmptyTitleForEventException
     */
    public static function create(string $title, DateRange $eventDate, PriceRange $priceRange, string $providerEventId, string $companyId): self
    {
        if (empty($title)) {
            throw EmptyTitleForEventException::create();
        }

        return new self(EventId::unique(), $title, $eventDate, $priceRange, $providerEventId, $companyId);
    }

    public function title(): string
    {
        return $this->title;
    }

    public function id(): EventId
    {
        return $this->id;
    }
    public function providerEventId(): string
    {
        return $this->providerEventId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function eventDate(): DateRange
    {
        return $this->eventDate;
    }

    public function priceRange(): PriceRange
    {
        return $this->priceRange;
    }
}