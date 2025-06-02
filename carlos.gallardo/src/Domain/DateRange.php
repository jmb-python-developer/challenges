<?php

declare(strict_types=1);

namespace Fever\Domain;

use DateTimeImmutable;
use Fever\Domain\Exceptions\InvalidDateRangeException;

final class DateRange
{
    /**
     * @var DateTimeImmutable
     */
    private $start;

    /**
     * @var DateTimeImmutable
     */
    private $end;

    private function __construct(DateTimeImmutable $start, DateTimeImmutable $end)
    {

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @throws InvalidDateRangeException
     */
    public static function create(DateTimeImmutable $start, DateTimeImmutable $end): self
    {
        if ($start > $end) {
            throw InvalidDateRangeException::withInvalidStart();
        }

        return new self($start, $end);
    }

    public function start(): DateTimeImmutable
    {
        return $this->start;
    }

    public function end(): DateTimeImmutable
    {
        return $this->end;
    }
}