<?php

declare(strict_types=1);

namespace Fever\Infrastructure\Persistence;

use Fever\Application\Query\EventFinder;
use Fever\Application\Query\EventView;
use Zend\Db\Adapter\Adapter;

class SQLiteEventFinder implements EventFinder
{
    /**
     * @var Adapter
     */
    private $adapter;

    private $tableName = 'events';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function search(string $startsAt, string $endsAt): array
    {
        $sql = "SELECT id, title, start, end, min_price, max_price 
                FROM $this->tableName
                WHERE date(start) >= date(:starts_at) AND date(end) <= date(:ends_at);";

        $statement = $this->adapter->createStatement($sql);

        $result = $statement->execute([':starts_at' => $startsAt, ':ends_at' => $endsAt]);
        $rows = [];
        foreach ($result as $row) {
            $startDateTime = \DateTimeImmutable::createFromFormat(DATE_ATOM, $row['start']);
            $endDateTime = \DateTimeImmutable::createFromFormat(DATE_ATOM, $row['end']);

            $rows[] = new EventView(
                $row['id'],
                $row['title'],
                $startDateTime->format('Y-m-d'),
                $endDateTime->format('Y-m-d'),
                $startDateTime->format('H:i:s'),
                $endDateTime->format('H:i:s'),
                floatval($row['min_price']),
                floatval($row['max_price'])
            );
        }

        return $rows;
    }
}
