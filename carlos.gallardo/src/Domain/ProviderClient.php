<?php

declare(strict_types=1);

namespace Fever\Domain;

use Iterator;

interface ProviderClient
{
    public function events(): iterable;
}
