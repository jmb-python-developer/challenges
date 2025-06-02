<?php

use Phpmig\Adapter;
use Pimple\Container;

$container = new Container();

$dbFile = __DIR__ . '/fever.db';

if (!file_exists($dbFile)) {
    $db =new SQLite3($dbFile, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
}

$dsn = 'sqlite:/' . __DIR__ . '/fever.db';
// Get dynamically
$container['db'] = function () use ($dsn){
    $dbh = new \PDO($dsn, '', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbh;
};

$container['phpmig.adapter'] = function ($c) {
    return new Adapter\PDO\Sql($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;


$array = new ArrayObject();

//$array->offsetSet('phpmig.adapter', new DbAdapter($container->get(ZendAdapter::class), 'migrations'));