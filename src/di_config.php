<?php
declare(strict_types=1);

use App\Classes\ClassFirst;
use App\Classes\ClassInterface;
use App\Classes\MyEmployers;
use App\Classes\MyUsers;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return [
    \PDO::class => [
        'arguments' => [
            'dsn' => 'sqlite:' . __DIR__ . '/../var/data.db',
        ],
    ],

    MyUsers::class => [
        'arguments' => [
            'users' => '@data',
        ],
    ],
    MyEmployers::class => [
        'arguments' => [
            'employers' => '@data',
        ],
    ],

    LoggerInterface::class => static function (string $loggerName, string $logFile) {
        return new Logger($loggerName, [new StreamHandler($logFile)]);
    },

    ClassInterface::class => ClassFirst::class,

    ClassFirst::class => [
        'arguments' => [
            'file' => '@logFile'
        ],
    ],
    // simple data
    'data' => ['user1', 'user2'],
    'logFile' => __DIR__ . '/../var/log.log',
    'loggerName' => 'app-logger',
];
