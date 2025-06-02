<?php

declare(strict_types=1);

namespace Fever\Infrastructure\Persistence;

use Fever\Domain\MessageBroker;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class SQLiteMessageBroker implements MessageBroker
{
    private const TABLE_NAME = 'queue';

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

    public function produce(string $message): void
    {
        $this->table()->insert(
            [
                'message' => $message,
            ]
        );
    }

    public function consume(): string
    {
        $result = $this->table()->select(function(Select $select){
            $select
                ->limit(1)
                ->order(['id' => Select::ORDER_DESCENDING]);
        })->current();

        $row = iterator_to_array($result);

        return $row['message'] ?? '';
    }

    private function table(): TableGateway
    {
        if (!$this->table) {
            $this->table = new TableGateway(self::TABLE_NAME, $this->adapter);
        }

        return $this->table;
    }
}
