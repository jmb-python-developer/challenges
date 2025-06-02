<?php

use Phpmig\Migration\Migration;

class CreateMessageQueueTable extends Migration
{
    public function up()
    {
        $sql = <<<SQL
    create table if not exists queue
    (
        id      integer not null
            constraint queue_pk
                primary key autoincrement,
        message text    not null
    );
SQL;
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE `queue`";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}
