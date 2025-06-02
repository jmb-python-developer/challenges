<?php

declare(strict_types=1);

namespace Fever\Application\Query;

class SearchEventsQuery implements Query
{
    /**
     * @var string
     */
    private $startsAt;

    /**
     * @var string
     */
    private $endsAt;

    public function __construct(string $startsAt, string $endsAt)
    {
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
    }

    public function startsAt(): string
    {
        return $this->startsAt;
    }

    public function endsAt(): string
    {
        return $this->endsAt;
    }
}
