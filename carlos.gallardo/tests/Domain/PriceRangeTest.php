<?php

declare(strict_types=1);

namespace Tests\Domain;

use Fever\Domain\Exceptions\InvalidPriceRangeException;
use Fever\Domain\PriceRange;
use PHPUnit\Framework\TestCase;

class PriceRangeTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateAPriceRange(): void
    {
        $min = 100.00;
        $max = 200.00;
        $priceRange = PriceRange::create($min, $max);

        $this->assertSame($priceRange->min(), $min);
        $this->assertSame($priceRange->max(), $max);
    }
    /**
     * @test
    */
    public function shouldCreateAPriceRangeWithSameValues(): void
    {
        $min = 100.00;
        $max = 100.00;
        $priceRange = PriceRange::create($min, $max);

        $this->assertSame($priceRange->min(), $min);
        $this->assertSame($priceRange->max(), $max);
    }

    /**
     * @test
     */
    public function shouldFailIfMinGreaterThanMax(): void
    {
        $this->expectException(InvalidPriceRangeException::class);
        PriceRange::create(100, 50);
    }

    /**
     * @test
     */
    public function shouldFailIfMaxLowerThanMin(): void
    {
        $this->expectException(InvalidPriceRangeException::class);
        PriceRange::create(100, 50);
    }
}
