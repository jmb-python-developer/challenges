<?php

declare(strict_types=1);

namespace tests\Application\Command;

use Fever\Application\Command\CommandHandler;
use Fever\Application\Command\SyncEventCommand;
use Fever\Application\Command\SyncEventCommandHandler;
use Fever\Domain\Exceptions\InvalidHierarchyException;
use Fever\Domain\Exceptions\MultipleRootsException;
use Tests\Infrastructure\Persistence\InMemoryEventRepository;
use Tests\Infrastructure\Persistence\InMemoryMessageBroker;
use Tests\Infrastructure\Scenario\AbstractCommandHandlerScenario;

class SyncEventCommandHandlerTest extends AbstractCommandHandlerScenario
{
    /**
     * @var InMemoryEventRepository
     */
    private $repository;

    /**
     * @var SyncEventCommandHandler
     */
    private $commandHandler;

    public function setUp(): void
    {
        $this->repository = new InMemoryEventRepository();
        $this->commandHandler = new SyncEventCommandHandler($this->repository);
        parent::setUp();
    }

    /**
     * @test
     */
    public function shouldSyncEvent(): void
    {
        $this->commandHandler($this->repository)->handle(
            new SyncEventCommand(
                'any-title',
                '1234',
                '1',
                new \DateTimeImmutable('now'),
                new \DateTimeImmutable('tomorrow'),
                100.00,
                200.00
            )
        );


        $this->assertCount(1, $this->repository->events());
    }

    private function commandHandler($repository): CommandHandler
    {
        return new SyncEventCommandHandler($repository);
    }
}
