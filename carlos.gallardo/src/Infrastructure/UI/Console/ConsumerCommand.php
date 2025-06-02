<?php

declare(strict_types=1);

namespace Fever\Infrastructure\UI\Console;

use Fever\Application\Command\CommandHandler;
use Fever\Application\Command\ProjectCompanyHierarchyCommand;
use Fever\Application\Command\ProjectCompanyHierarchyCommandHandler;
use Fever\Domain\MessageBroker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends Command
{
    /**
     * @var MessageBroker
     */
    private $messageBroker;

    /**
     * @var ProjectCompanyHierarchyCommandHandler | CommandHandler
     */
    private $persistCompanyHierarchyCommandHandler;

    public function __construct(MessageBroker $messageBroker, CommandHandler $persistCompanyHierarchyCommandHandler)
    {
        $this->messageBroker = $messageBroker;
        $this->persistCompanyHierarchyCommandHandler = $persistCompanyHierarchyCommandHandler;
        parent::__construct();
    }
    protected function configure()
    {
        $this->setName('message:consumer');
        $this->setDescription('Message consumer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $this->messageBroker->consume();

        $this->persistCompanyHierarchyCommandHandler->handle(
            new ProjectCompanyHierarchyCommand(json_decode($message, true))
        );

        return 1;
    }
}
