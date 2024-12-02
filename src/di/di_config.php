<?php
declare(strict_types=1);

use Di\Classes\ClassFirst;
use Di\Classes\ClassInterface;
use Di\Classes\DiFactoryPerson;
use Di\Classes\MyEmployers;
use Di\Classes\MyUsers;
use Di\Classes\Person;
use Di\Classes\Travel;
use Di\Classes\Variadic\RuleEmail;
use Di\Classes\Variadic\RuleEngine;
use Di\Classes\Variadic\RuleMinMax;
use Di\Classes\Variadic\RuleTrim;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function Kaspi\DiContainer\diAutowire;
use function Kaspi\DiContainer\diGet;

$config = [
    // simple data
    'app.logger.name' => 'app-logger',
    'app.logger.file' => __DIR__ . '/../../var/log.log',
    'app.shared.users' => ['user1', 'user2'],
    'sqlite-dsn' => 'sqlite:' . __DIR__ . '/../../var/data.db',
];


$definitions = [
    diAutowire(\PDO::class)
        // bind by name
        ->bindArguments(dsn: diGet('sqlite-dsn')),

    LoggerInterface::class => static function (ContainerInterface $container) {
        return new Logger(
            name: $container->get('app.logger.name'),
            handlers: [new StreamHandler(stream: $container->get('app.logger.file'))]);
    },

    ClassInterface::class => diGet(ClassFirst::class),

    ClassFirst::class => diAutowire(ClassFirst::class)
        ->bindArguments(diGet('app.logger.file')),

    Person::class => diAutowire(DiFactoryPerson::class),

    diAutowire(Travel::class)
        // unsorted by name
        ->bindArguments(
            travelOptions: (object) ['speed' => 10, 'gravity' => 'low'],
            travelFrom: 'Earth',
            travelTo: 'Moon',
        ),

    // test non type hint argument name for Di\Classes\ClassWithEmptyType::class
    'dependency' => static function (ContainerInterface $container) {
        return $container->get(Travel::class);
    },

    diAutowire(RuleMinMax::class)
        // bind by index
        ->bindArguments(10, 100),
    // Variadic arguments
    diAutowire(RuleEngine::class)
        // bind variadic by name
        ->bindArguments(
            rule: [
                diAutowire(RuleTrim::class),
                diAutowire(RuleMinMax::class),
                diAutowire(RuleEmail::class),
            ]
        ),
    'services.rules.may-rule' => diAutowire(RuleEngine::class)
        // bind variadic by index
        ->bindArguments(
            // parameter at position #0
            diAutowire(RuleTrim::class),
            // parameter at position #1
            diAutowire(RuleMinMax::class)
                ->bindArguments(min: 4, max: 23)
        )
];


$definitions1 = [
    diAutowire(MyUsers::class)
        ->bindArguments(users: diGet('app.shared.users'))
];

$definitions2 = [
    diAutowire(MyEmployers::class)
        ->bindArguments(employers: diGet('app.shared.users'))
];

return array_merge($config, $definitions, $definitions1, $definitions2);
