<?php

declare(strict_types=1);

namespace Fever\Infrastructure\UI\Rest;

use Fever\Application\Query\EventView;
use Fever\Application\Query\QueryHandler;
use Fever\Application\Query\SearchEventsQuery;
use Fever\Application\Query\SearchEventsQueryHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;

class SearchEventsController
{
    /**
     * @var SearchEventsQueryHandler | QueryHandler
     */
    private $queryHandler;

    public function __construct(QueryHandler $queryHandler)
    {
        $this->queryHandler = $queryHandler;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response(StatusCode::HTTP_OK);
        $startsAt = $request->getQueryParams()["starts_at"] ?? null;
        $endsAt = $request->getQueryParams()["ends_at"] ?? null;

        if (null === $startsAt || null === $endsAt) {
            $body = $this->buildBody(false, null, 'MISSING_PARAMETERS', 'Parameter starts_at or ends_at are missing.');
            return $response->withJson($body, StatusCode::HTTP_BAD_REQUEST);
        }

        if (false === strtotime($startsAt) || false === strtotime($endsAt)) {
            $body = $this->buildBody(false, null, 'INVALID_DATE_FORMAT', 'Parameter starts_at or ends_at are not valid dates.');
            return $response->withJson($body, StatusCode::HTTP_BAD_REQUEST);
        }

        try {
            $eventViews = $this->queryHandler->handle(new SearchEventsQuery($startsAt, $endsAt));
            $body = array_map(function(EventView $view) {
                return $view->toArray();
            }, $eventViews);

            $response = $response->withJson($this->buildBody(true, $body), StatusCode::HTTP_OK);
        } catch (\Throwable $e) {
            $body = $this->buildBody(false, null, 'INTERNAL_SERVER_ERROR', $e->getMessage());
            $response = $response->withJson($body, StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    private function buildBody(bool $success, ?array $events, ?string $code = null, ?string $message = null): array
    {
        return [
            'error' => $success ? null : [
                'code' => $code,
                'message' => $message
            ],
            'data'=> !$success ? null : [
                'events' => array_values($events),
            ],
        ];
    }
}

