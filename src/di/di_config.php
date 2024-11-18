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

$config = [
    // simple data
    'app.logger.name' => 'app-logger',
    'app.logger.file' => __DIR__ . '/../../var/log.log',
    'app.shared.users' => ['user1', 'user2'],
    'sqlite-dsn' => 'sqlite:' . __DIR__ . '/../../var/data.db',
];


$definitions = [
    diAutowire(\PDO::class)
        ->addArgument('dsn', '@sqlite-dsn'),

    LoggerInterface::class => static function (ContainerInterface $container) {
        return new Logger(
            name: $container->get('app.logger.name'),
            handlers: [new StreamHandler(stream: $container->get('app.logger.file'))]);
    },

    ClassInterface::class => ClassFirst::class,

    ClassFirst::class => diAutowire(ClassFirst::class, ['file' => '@app.logger.file']),

    Person::class => diAutowire(DiFactoryPerson::class),

    diAutowire(Travel::class)
        ->addArgument('travelFrom', 'Earth')
        ->addArgument('travelTo', 'Moon')
        ->addArgument('travelOptions', (object) ['speed' => 10, 'gravity' => 'low']),

    // test non type hint argument name for Di\Classes\ClassWithEmptyType::class
    'dependency' => static function (ContainerInterface $container) {
        return $container->get(Travel::class);
    },

    // Variadic arguments
    diAutowire(RuleMinMax::class, [
        'min' => 10,
        'max' => 100,
    ]),
    diAutowire(RuleEngine::class)
        ->addArgument('rule', [
            RuleTrim::class,
            RuleMinMax::class,
            RuleEmail::class,
        ]),
];

$definitions[] = diAutowire(MyUsers::class, ['users' => '@app.shared.users']);
$definitions[] = diAutowire(MyEmployers::class, ['employers' => '@app.shared.users']);

return array_merge($config, $definitions);
