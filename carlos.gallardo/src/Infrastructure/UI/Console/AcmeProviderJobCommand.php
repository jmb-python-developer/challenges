<?php

declare(strict_types=1);

namespace Fever\Infrastructure\UI\Console;

use Fever\Application\Command\CommandHandler;
use Fever\Application\Command\SyncEventCommand;
use Fever\Application\Command\SyncEventCommandHandler;
use Fever\Domain\Exceptions\EmptyTitleForEventException;
use Fever\Domain\Exceptions\InvalidDateRangeException;
use Fever\Domain\Exceptions\InvalidPriceRangeException;
use Fever\Domain\ProviderClient;
use Fever\Infrastructure\ProviderClient\EventDTO;
use Fever\Infrastructure\ProviderClient\AcmeProviderClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AcmeProviderJobCommand extends Command
{
    /**
     * @var SyncEventCommandHandler
     */
    private $publishEventCommandHandler;

    /**
     * @var AcmeProviderClient
     */
    private $feverProviderClient;

    public function __construct(CommandHandler $publishEventCommandHandler, ProviderClient $feverProviderClient)
    {
        $this->publishEventCommandHandler = $publishEventCommandHandler;
        $this->feverProviderClient = $feverProviderClient;
        parent::__construct();
    }
    protected function configure()
    {
        $this->setName('provider-job:acme');
        $this->setDescription('Provider job for acme company');
    }

    /**
     * @throws InvalidDateRangeException
     * @throws InvalidPriceRangeException
     * @throws EmptyTitleForEventException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var EventDTO $event */
        foreach ($this->feverProviderClient->events() as $event) {
            $this->publishEventCommandHandler->handle(
                new SyncEventCommand(
                    $event->title,
                    $event->providerEventId,
                    $event->companyId,
                    $event->start,
                    $event->end,
                    $event->minPrice,
                    $event->maxPrice
                )
            );
        }

        return 1;
    }
}
