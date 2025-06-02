<?php

declare(strict_types=1);

namespace Fever\Domain;

interface DomainEvent
{
    public function toArray(): array;
}