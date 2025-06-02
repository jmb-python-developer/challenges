<?php

declare(strict_types=1);

namespace Fever\Application\Query;

interface EventFinder
{
    public function search(string $startsAt, string $endsAt): array;
}
