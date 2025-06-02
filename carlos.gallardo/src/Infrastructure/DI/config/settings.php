<?php

declare(strict_types=1);

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails'    => true,
        'addContentLengthHeader' => false,
        'logger' => [
            'name'  => 'fever',
            'path'  => __DIR__ . '/../../../../logs/app.log',
            'level' => Logger::ERROR,
        ],
        'authSecret' => 'this-is-a-secret',
        'db' => [
            'charset'        => 'UTF8',
            'database'       => __DIR__ . '/../../../../fever.db',
            'driver'         => 'Pdo_Sqlite',
            'driver_options' => [
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ],
        ]
    ],
];
