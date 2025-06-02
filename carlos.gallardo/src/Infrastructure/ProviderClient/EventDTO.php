<?php

declare(strict_types=1);

namespace Fever\Infrastructure\ProviderClient;

use DateTimeImmutable;

class EventDTO
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $providerEventId;

    /**
     * @var string
     */
    public $companyId;

    /**
     * @var DateTimeImmutable
     */
    public $start;

    /**
     * @var DateTimeImmutable
     */
    public $end;
    /**
     * @var float
     */
    public $minPrice;

    /**
     * @var float
     */
    public $maxPrice;

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
}
