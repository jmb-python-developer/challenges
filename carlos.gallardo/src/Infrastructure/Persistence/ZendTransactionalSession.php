<?php

declare(strict_types=1);

namespace Fever\Infrastructure\Persistence;

use Fever\Application\Command\TransactionalSession;
use Zend\Db\Adapter\Adapter;

class ZendTransactionalSession implements TransactionalSession
{
    /**
     * @var Adapter;
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @throws \Throwable
     */
    public function executeAtomically(callable $operation)
    {
        $this->adapter->getDriver()->getConnection()->beginTransaction();

        try {
            $outcome = $operation();
            $this->adapter->getDriver()->getConnection()->commit();

            return $outcome;
        } catch (\Throwable $e) {
            $this->adapter->getDriver()->getConnection()->rollback();

            throw $e;
        }
    }
}
