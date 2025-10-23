<?php

declare(strict_types=1);

use Attributes\Classes\AppLogger;
use Attributes\Classes\Collection\RuleAlphabetOnly;
use Attributes\Classes\Collection\RuleTrim;
use Attributes\Classes\Variadic\RuleMinMax;
use function Kaspi\DiContainer\diAutowire;
use function Kaspi\DiContainer\diGet;


return static function (): \Generator {
    yield 'services.rule-collection' => static fn(
        RuleTrim         $ruleTrim,
        RuleMinMax       $ruleMinMax,
        RuleAlphabetOnly $ruleAlphabetOnly,
    ) => func_get_args();

    yield 'services.rule-collection-lazy' => static function (Psr\Container\ContainerInterface $container): \Generator {
        yield $container->get(RuleTrim::class);

        yield $container->get(RuleMinMax::class);

        yield $container->get(RuleAlphabetOnly::class);
    };

    yield diAutowire(RuleMinMax::class)
        ->bindArguments(min: 10, max: 255);

    yield 'services.rules.rule-min-max-10-100' => diAutowire(RuleMinMax::class)
        // bind by name
        ->bindArguments(min: 10, max: 100);

    yield 'app.pdo' => diAutowire(PDO::class, isSingleton: true)
        ->bindArguments(dsn: diGet('sqlite.dsn'))
        // setup service via setter method
        ->setup('setAttribute', attribute: \PDO::ATTR_CASE, value: \PDO::CASE_UPPER);

    yield diAutowire(AppLogger::class)
        // bind by index
        ->bindArguments('app-logger', diGet('app_config.logger_file'));
};
