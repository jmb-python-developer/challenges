<?php

declare(strict_types=1);

namespace Fever\Infrastructure\Application;

use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;

class CustomClassNameExtractor implements CommandNameExtractor
{
    public function extract($command)
    {
        return get_class($command) . 'Handler';
    }
}