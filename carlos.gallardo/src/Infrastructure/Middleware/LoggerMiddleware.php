<?php

declare(strict_types=1);

namespace Fever\Infrastructure\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class LoggerMiddleware
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        try {
            $response = $next($request, $response);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());

            throw $exception;
        }

        return $response;
    }
}
