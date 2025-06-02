<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Scenario;

use Fever\Application\Command\Command;
use Fever\Application\Command\CommandHandler;
use Fever\Domain\AggregateRoot;
use PHPUnit\Framework\Assert as PHPUnitAssert;

class CommandHandlerScenario
{
    /**
     * @var array
     */
    private $domainEvents;

    private $repository;

    /**
     * @var CommandHandler
     */
    private $commandHandler;

    /**
     * @var AbstractCommandHandlerScenario
     */
    private $commandHandlerScenario;

    public function __construct(AbstractCommandHandlerScenario $commandHandlerScenario)
    {
        $this->commandHandlerScenario = $commandHandlerScenario;
    }

    public function setUp(CommandHandler $commandHandler, $repository): self
    {
        $this->commandHandler = $commandHandler;
        $this->repository = $repository;

        return $this;
    }

    public function given(AggregateRoot $aggregateRoot): self
    {
        $this->repository->save($aggregateRoot);

        return $this;
    }

    public function expectException(string $exceptionExpected): self
    {
        $this->commandHandlerScenario->expectException($exceptionExpected);

        return $this;
    }

    public function when(Command $command): self
    {
        $this->domainEvents = $this->commandHandler->handle($command);

        return $this;
    }

    public function then(array $events): void
    {
        PHPUnitAssert::assertEquals(count($events), count($this->domainEvents));
        PHPUnitAssert::assertEquals($events, $this->domainEvents);
    }
}
