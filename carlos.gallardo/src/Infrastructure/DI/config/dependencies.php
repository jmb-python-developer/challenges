<?php

declare(strict_types=1);

use Fever\Infrastructure\ProviderClient\AcmeProviderClient;
use Fever\Infrastructure\UI\Console\AcmeProviderJobCommand;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\Locator\CallableLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Fever\Application\Command\SyncEventCommandHandler;
use Fever\Application\Command\TransactionalCommandHandler;
use Fever\Application\Command\TransactionalSession;
use Fever\Application\Query\EventFinder;
use Fever\Application\Query\SearchEventsQueryHandler;
use Fever\Domain\EventRepository;
use Fever\Domain\MessageBroker;
use Fever\Infrastructure\Application\CustomClassNameExtractor;
use Fever\Infrastructure\Persistence\SQLiteEventFinder;
use Fever\Infrastructure\Persistence\SQLiteEventRepository;
use Fever\Infrastructure\Persistence\SQLiteMessageBroker;
use Fever\Infrastructure\Persistence\ZendTransactionalSession;
use Fever\Infrastructure\UI\Console\ConsumerCommand;
use Psr\Log\LoggerInterface;
use Slim\App;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;
use Zend\Db\Adapter\Adapter;

return function (App $app) {
    $container = $app->getContainer();

    $container[LoggerInterface::class] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));

        return $logger;
    };

    $container[Adapter::class] = function ($c) {
        return new Adapter($c->get('settings')['db']);
    };

    $container[TransactionalSession::class] = function () use ($container) {
        return new ZendTransactionalSession($container[Adapter::class]);
    };

    $container[CommandBus::class] = function () use ($container) {
        $commandHandlerMiddleware = new CommandHandlerMiddleware(
            new CustomClassNameExtractor(),
            new CallableLocator([$container, 'get']),
            new HandleInflector()
        );

        return new CommandBus(
            [
                $commandHandlerMiddleware
            ]
        );
    };

    // Repositories
    $container[EventRepository::class] = function () use ($container) {
        return new SQLiteEventRepository($container[Adapter::class]);
    };

    $container[EventFinder::class] = function () use ($container) {
        return new SQLiteEventFinder($container[Adapter::class]);
    };

    // Message Broker
    /*$container[MessageBroker::class] = function () use ($container) {
        return new SQLiteMessageBroker($container[Adapter::class]);
    };*/

    // Use cases
    $container[SyncEventCommandHandler::class] = function () use ($container) {
        return new TransactionalCommandHandler(
            new SyncEventCommandHandler($container->get(EventRepository::class)),
            $container[TransactionalSession::class]
        );
    };

    $container[SearchEventsQueryHandler::class] = function () use ($container) {
        return new SearchEventsQueryHandler($container->get(EventFinder::class));
    };

    // Commands
    /*$container[ConsumerCommand::class] = function () use ($container) {
        return new ConsumerCommand(
            $container->get(MessageBroker::class),

        );
    };*/

    $acmeUrl = 'https://provider.code-challenge.feverup.com/api/events';
    $container[AcmeProviderJobCommand::class] = function () use ($container, $acmeUrl) {
        return new AcmeProviderJobCommand(
            $container->get(SyncEventCommandHandler::class),
            new AcmeProviderClient($acmeUrl)
        );
    };
};
