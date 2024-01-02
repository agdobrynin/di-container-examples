<?php
declare(strict_types=1);

use Di\Classes\ClassFirst;
use Di\Classes\ClassInterface;
use Di\Classes\MyEmployers;
use Di\Classes\MyUsers;
use Kaspi\DiContainer\Interfaces\DiContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return [
    \PDO::class => [
        'arguments' => [
            'dsn' => 'sqlite:' . __DIR__ . '/../../var/data.db',
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

    LoggerInterface::class => static function (DiContainerInterface $container) {
        return new Logger(
            name: $container->get('logger.name'),
            handlers: [new StreamHandler(stream: $container->get('logger.file'))]);
    },

    ClassInterface::class => ClassFirst::class,

    ClassFirst::class => [
        'arguments' => [
            'file' => '@logger.file'
        ],
    ],
    // simple data
    'data' => ['user1', 'user2'],
    'logger.file' => __DIR__ . '/../../var/log.log',
    'logger.name' => 'app-logger',
];
