<?php
declare(strict_types=1);

use Di\Classes\ClassFirst;
use Di\Classes\ClassInterface;
use Di\Classes\DiFactoryPerson;
use Di\Classes\MyEmployers;
use Di\Classes\MyUsers;
use Di\Classes\Person;
use Di\Classes\Travel;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function Kaspi\DiContainer\diDefinition;

$config = [
    // simple data
    'app.logger.name' => 'app-logger',
    'app.logger.file' => __DIR__ . '/../../var/log.log',
    'app.shared.users' => ['user1', 'user2'],
    'sqlite-dsn' => 'sqlite:' . __DIR__ . '/../../var/data.db',
];


$definitions = [
    \PDO::class => [
        'arguments' => [
            'dsn' => '@sqlite-dsn',
        ],
    ],

    LoggerInterface::class => static function (ContainerInterface $container) {
        return new Logger(
            name: $container->get('app.logger.name'),
            handlers: [new StreamHandler(stream: $container->get('app.logger.file'))]);
    },

    ClassInterface::class => ClassFirst::class,

    ClassFirst::class => diDefinition(arguments: ['file' => '@app.logger.file']),

    Person::class => DiFactoryPerson::class,

    Travel::class => diDefinition(arguments: [
        'travelFrom' => 'Earth',
        'travelTo' => 'Moon',
        'travelOptions' => (object) ['speed' => 10, 'gravity' => 'low'],
    ]),
    // test non type hint argument name for Di\Classes\ClassWithEmptyType::class
    'dependency' => static function (ContainerInterface $container) {
        return $container->get(Travel::class);
    },
];

// use helper.
$definitions += diDefinition(containerKey: MyUsers::class, arguments: ['users' => '@app.shared.users']);
$definitions += diDefinition(containerKey: MyEmployers::class, arguments: ['employers' => '@app.shared.users']);

return array_merge($config, $definitions);
