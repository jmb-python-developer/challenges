<?php

declare(strict_types=1);

namespace Fever\Application\Query;

class EventView
{
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
    private $startDate;

    /**
     * @var string
     */
    private $startTime;

    /**
     * @var string
     */
    private $endDate;

    /**
     * @var string
     */
    private $endTime;

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
        string $startDate,
        string $endDate,
        string $startTime,
        string $endTime,
        float $minPrice,
        float $maxPrice
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->startDate = $startDate;
        $this->startTime = $startTime;
        $this->endDate = $endDate;
        $this->endTime = $endTime;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'min_price' => $this->minPrice,
            'max_price' => $this->maxPrice,
        ];
    }
}
