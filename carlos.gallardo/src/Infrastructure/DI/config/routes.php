<?php

declare(strict_types=1);

use Fever\Application\Query\SearchEventsQueryHandler;
use Fever\Infrastructure\Middleware\LoggerMiddleware;
use Fever\Infrastructure\UI\Rest\SearchEventsController;
use Psr\Log\LoggerInterface;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    $app->add(new LoggerMiddleware($container->get(LoggerInterface::class)));
    $app->get(
        '/search',
        new SearchEventsController($container->get(SearchEventsQueryHandler::class))
    );
};
