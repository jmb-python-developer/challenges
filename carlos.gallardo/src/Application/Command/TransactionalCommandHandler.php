<?php

declare(strict_types=1);

namespace Fever\Application\Command;

class TransactionalCommandHandler implements CommandHandler
{
    /**
     * @var TransactionalSession
     */
    private $session;

    /**
     * @var CommandHandler
     */
    private $commandHandler;

    public function __construct(CommandHandler $commandHandler, TransactionalSession $session)
    {
        $this->session        = $session;
        $this->commandHandler = $commandHandler;
    }

    public function handle(Command $command)
    {
        $operation = function () use ($command) {
            return $this->commandHandler->handle($command);
        };

        return $this->session->executeAtomically($operation);
    }
}
