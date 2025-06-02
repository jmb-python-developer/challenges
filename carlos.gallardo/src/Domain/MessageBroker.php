<?php

declare(strict_types=1);

namespace Fever\Domain;

interface MessageBroker
{
    public function produce(string $message): void;

    public function consume(): string;
}