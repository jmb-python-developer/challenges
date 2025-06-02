<?php

declare(strict_types=1);

namespace Fever\Domain;

use Fever\Domain\Exceptions\InvalidPriceRangeException;

final class PriceRange
{
    /**
     * @var float
     */
    private $min;

    /**
     * @var float
     */
    private $max;

    private function __construct(float $min, float $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @throws InvalidPriceRangeException
     */
    public static function create(float $min, float $max): self
    {
        if ($min > $max) {
            throw InvalidPriceRangeException::withInvalidMinPrice();
        }

        return new self($min, $max);
    }

    public function min(): float
    {
        return $this->min;
    }

    public function max(): float
    {
        return $this->max;
    }
}