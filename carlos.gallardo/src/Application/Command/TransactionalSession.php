<?php

declare(strict_types=1);

namespace Fever\Application\Command;

interface TransactionalSession
{
    public function executeAtomically(callable $operation);
}
