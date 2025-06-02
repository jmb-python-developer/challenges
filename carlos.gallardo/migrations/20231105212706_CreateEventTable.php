<?php

declare(strict_types=1);

use Phpmig\Migration\Migration;

class CreateEventTable extends Migration
{
    public function up()
    {
        $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS `events` (
        `id` VARCHAR(200) NOT NULL,
        `title` VARCHAR(200) NOT NULL,
        `provider_event_id` VARCHAR(100) NOT NULL,
        `company_id` VARCHAR(100) NOT NULL,
        `start` DATETIME NOT NULL,
        `end` DATETIME NOT NULL,
        `min_price` FLOAT NOT NULL,
        `max_price` FLOAT NOT NULL,
        `updated_at` DATETIME NOT_NULL,
        PRIMARY KEY(`id`)
    );
SQL;
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE `events`";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
