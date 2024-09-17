<?php
declare(strict_types=1);

use Di\Classes\ClassFirst;
use Di\Classes\ClassInterface;
use Di\Classes\DiFactoryPerson;
use Di\Classes\MyEmployers;
use Di\Classes\MyUsers;
use Di\Classes\Person;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

$config = [
    // simple data
    'app' => [
        'logger' => [
            'name' => 'app-logger',
            'file' => __DIR__ . '/../../var/log.log',
        ],
        'shared' => [
            'users' => ['user1', 'user2'],
        ],
    ],
    'sqlite-dsn' => 'sqlite:' . __DIR__ . '/../../var/data.db',
    'travelFrom' => 'Earth',
    'travelTo' => 'Moon',
    'travelOptions' => (object) ['speed' => 10, 'gravity' => 'low'],
];


$definitions = [
    \PDO::class => [
        'arguments' => [
            'dsn' => '@sqlite-dsn',
        ],
    ],

    MyUsers::class => [
        'arguments' => [
            'users' => '@app.shared.users',
        ],
    ],
    MyEmployers::class => [
        'arguments' => [
            'employers' => '@app.shared.users',
        ],
    ],

    LoggerInterface::class => static function (ContainerInterface $container) {
        return new Logger(
            name: $container->get('@app.logger.name'),
            handlers: [new StreamHandler(stream: $container->get('@app.logger.file'))]);
    },

    ClassInterface::class => ClassFirst::class,

    ClassFirst::class => [
        'arguments' => [
            'file' => '@app.logger.file'
        ],
    ],

    Person::class => DiFactoryPerson::class
];

return array_merge($config, $definitions);
