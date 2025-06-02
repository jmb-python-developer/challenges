<?php

declare(strict_types=1);

namespace Fever\Application\Command;

interface CommandHandler
{
    public function handle(Command $command);
}
