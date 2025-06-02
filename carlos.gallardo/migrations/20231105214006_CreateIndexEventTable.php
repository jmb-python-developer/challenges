<?php

declare(strict_types=1);

use Phpmig\Migration\Migration;

class CreateIndexEventTable extends Migration
{
    public function up()
    {
        $container = $this->getContainer();

        $sql = <<<SQL
    CREATE INDEX idx_event_id
    ON events (company_id, provider_event_id);
SQL;
        $container['db']->query($sql);

        $sql = <<<SQL
    CREATE INDEX idx_event_date_start
    ON events (start);
SQL;
        $container['db']->query($sql);

        $sql = <<<SQL
    CREATE INDEX idx_event_date_end
    ON events (end);
SQL;
        $container['db']->query($sql);
    }

    public function down()
    {
        $container = $this->getContainer();
        $sql = "DROP INDEX `idx_event_id`";
        $container['db']->query($sql);

        $sql = "DROP INDEX `idx_event_date_start`";
        $container['db']->query($sql);

        $sql = "DROP INDEX `idx_event_date_end`";
        $container['db']->query($sql);
    }
}
