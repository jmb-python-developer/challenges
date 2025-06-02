<?php

declare(strict_types=1);

namespace Fever\Application\Command;

use DateTimeImmutable;

class SyncEventCommand implements Command
{
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
        string $title,
        string $providerEventId,
        string $companyId,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        float $minPrice,
        float $maxPrice
    ) {
        $this->title = $title;
        $this->providerEventId = $providerEventId;
        $this->companyId = $companyId;
        $this->start = $start;
        $this->end = $end;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function providerEventId(): string
    {
        return $this->providerEventId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function start(): DateTimeImmutable
    {
        return $this->start;
    }

    public function end(): DateTimeImmutable
    {
        return $this->end;
    }

    public function minPrice(): float
    {
        return $this->minPrice;
    }

    public function maxPrice(): float
    {
        return $this->maxPrice;
    }
}
