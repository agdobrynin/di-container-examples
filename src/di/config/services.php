<?php

declare(strict_types=1);

use Di\Classes\ClassFirst;
use Di\Classes\ClassInterface;
use Di\Classes\ClassWithUnionType;
use Di\Classes\DiFactoryPerson;
use Di\Classes\MyEmployers;
use Di\Classes\Person;
use Di\Classes\SetterImmutableMethod;
use Di\Classes\SetterMethod;
use Di\Classes\Travel;
use Di\Classes\Variadic\RuleEmail;
use Di\Classes\Variadic\RuleEngine;
use Di\Classes\Variadic\RuleMinMax;
use Di\Classes\Variadic\RuleTrim;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function Kaspi\DiContainer\{diAutowire, diGet};

return static function (): \Generator {
    yield diAutowire(\PDO::class)
        // bind by name
        ->bindArguments(dsn: diGet('sqlite-dsn'))
        // setup service via setter method
        ->setup('setAttribute', attribute: \PDO::ATTR_CASE, value: \PDO::CASE_UPPER);

    yield LoggerInterface::class => static function (ContainerInterface $container) {
        return new Logger(
            name: $container->get('app.logger.name'),
            handlers: [new StreamHandler(stream: $container->get('app.logger.file'))]
        );
    };

    yield ClassInterface::class => diGet(ClassFirst::class);

    yield ClassFirst::class => diAutowire(ClassFirst::class)
        ->bindArguments(diGet('app.logger.file'));

    yield Person::class => diAutowire(DiFactoryPerson::class);

    yield diAutowire(Travel::class)
        // unsorted by name
        ->bindArguments(
            travelOptions: (object)['speed' => 10, 'gravity' => 'low'],
            travelFrom: 'Earth',
            travelTo: 'Moon',
        );

    // test non type hint argument name for Di\Classes\ClassWithEmptyType::class
    yield 'dependency' => static function (ContainerInterface $container) {
        return $container->get(Travel::class);
    };

    yield diAutowire(RuleMinMax::class)
        // bind by index
        ->bindArguments(10, 100);

    // Variadic arguments
    yield diAutowire(RuleEngine::class)
        // bind variadic by name
        ->bindArguments(
            rule1: diAutowire(RuleTrim::class),
            rule2: diAutowire(RuleMinMax::class),
            rule3: diAutowire(RuleEmail::class),
        );

    yield 'services.rules.may-rule' => diAutowire(RuleEngine::class)
        // bind variadic by index
        ->bindArguments(
        // parameter at position #0
            diAutowire(RuleTrim::class),
            // parameter at position #1
            diAutowire(RuleMinMax::class)
                ->bindArguments(min: 4, max: 23)
        );

    yield diAutowire(ClassWithUnionType::class)
        ->bindArguments(dependency: diGet(MyEmployers::class));

    yield diAutowire(SetterMethod::class)
        ->setup('addRule', diGet(\Di\Classes\Collection\RuleTrim::class))
        ->setup('addRule', diGet(\Di\Classes\Collection\RuleMinMax::class))
        ->setup('addRule', diGet(\Di\Classes\Collection\RuleAlphabetOnly::class));

    yield diAutowire(SetterImmutableMethod::class)
        ->setupImmutable('withLogger');
};
