<?php

declare(strict_types=1);

namespace Tests\Domain;

use Fever\Domain\DateRange;
use Fever\Domain\Exceptions\InvalidDateRangeException;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateADateRange(): void
    {
        $today = new \DateTimeImmutable('now');
        $tomorrow = new \DateTimeImmutable('tomorrow');
        $dateRange = DateRange::create($today, $tomorrow);

        $this->assertSame($dateRange->start(), $today);
        $this->assertSame($dateRange->end(), $tomorrow);
    }

    /**
     * @test
     */
    public function shouldFailIfStartDateGreaterThanEndDate(): void
    {
        $this->expectException(InvalidDateRangeException::class);
        $today = new \DateTimeImmutable('now');
        $yesterday = new \DateTimeImmutable('yesterday');
        DateRange::create($today, $yesterday);
    }
}
