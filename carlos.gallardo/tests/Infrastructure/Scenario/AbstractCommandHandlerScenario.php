<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Scenario;

use PHPUnit\Framework\TestCase;

abstract class AbstractCommandHandlerScenario extends TestCase
{
    /**
     * @var CommandHandlerScenario
     */
    protected $scenario;

    public function setUp(): void
    {
        $this->scenario = new CommandHandlerScenario($this);
    }
}
