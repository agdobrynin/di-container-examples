<?php

declare(strict_types=1);

use Attributes\Classes\AppLogger;
use Attributes\Classes\Variadic\RuleMinMax;
use function Kaspi\DiContainer\diAutowire;

return static function (): \Generator {
    yield 'services.rules.rule-min-max-10-100' => diAutowire(RuleMinMax::class)
        // bind by name
        ->bindArguments(min: 10, max: 100);

    yield 'app.pdo' => diAutowire(PDO::class, isSingleton: true)
        ->bindArguments(dsn: 'sqlite:' . __DIR__ . '/../../../var/data.db');

    yield diAutowire(AppLogger::class)
        // bind by index
        ->bindArguments('app-logger', __DIR__ . '/../../../var/log.log');
};
