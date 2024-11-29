<?php

declare(strict_types=1);

use Attributes\Classes\AppLogger;
use Attributes\Classes\Variadic\RuleMinMax;
use function Kaspi\DiContainer\diAutowire;

return [
    'services.rules.rule-min-max-10-100' => diAutowire(RuleMinMax::class)
        ->addArgument('min', 10)
        ->addArgument('max', 100),
    'app.pdo' => diAutowire(PDO::class, isSingleton: true)
        ->addArgument('dsn', 'sqlite:' . __DIR__ . '/../../var/data.db'),
    diAutowire(AppLogger::class)
        ->addArgument('name', 'app-logger')
        ->addArgument('file', __DIR__ . '/../../var/log.log'),
];
