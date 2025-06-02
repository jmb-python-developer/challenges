<?php

declare(strict_types=1);

namespace Fever\Domain;

interface EventRepository
{
    public function save(Event $event): void;
}
