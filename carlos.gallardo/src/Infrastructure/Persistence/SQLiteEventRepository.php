<?php

declare(strict_types=1);

namespace Fever\Infrastructure\Persistence;

use Exception;
use Fever\Domain\Event;
use Fever\Domain\EventRepository;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class SQLiteEventRepository implements EventRepository
{
    private const TABLE_NAME = 'events';

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var TableGateway
     */
    private $table;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @throws Exception
     */
    public function save(Event $event): void
    {
        if (!$this->table()->select([
            'company_id' => $event->companyId(),
            'provider_event_id' => $event->providerEventId()
        ])->current()) {
            $this->table()->insert(
                [
                    'id' => $event->id()->id(),
                    'title' => $event->title(),
                    'provider_event_id' => $event->providerEventId(),
                    'company_id' => $event->companyId(),
                    'start' => $event->eventDate()->start()->format(DATE_ATOM),
                    'end' => $event->eventDate()->end()->format(DATE_ATOM),
                    'min_price' => $event->priceRange()->min(),
                    'max_price' => $event->priceRange()->max(),
                    'updated_at' => (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format(DATE_ATOM),
                ]
            );
        } else {
            $this->table()->update(
                [
                    'title' => $event->title(),
                    'start' => $event->eventDate()->start()->format(DATE_ATOM),
                    'end' => $event->eventDate()->end()->format(DATE_ATOM),
                    'min_price' => $event->priceRange()->min(),
                    'max_price' => $event->priceRange()->max(),
                    'updated_at' => (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format(DATE_ATOM),
                ],
                ['company_id' => $event->companyId(), 'provider_event_id' => $event->providerEventId()]
            );
        }
    }

    private function table(): TableGateway
    {
        if (!$this->table) {
            $this->table = new TableGateway(self::TABLE_NAME, $this->adapter);
        }

        return $this->table;
    }
}
