<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence;

use Fever\Domain\MessageBroker;

class InMemoryMessageBroker implements MessageBroker
{
    /**
     * @var array
     */
    private $messages = [];

    public function produce(string $message): void
    {
        $this->messages[] = $message;
    }

    public function consume(): string
    {
        return end($this->messages);
    }

    public function messages(): array
    {
        return $this->messages;
    }
}
