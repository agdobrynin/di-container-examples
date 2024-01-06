<?php

declare(strict_types=1);

$start = microtime(true);

require_once __DIR__ . '/../vendor/autoload.php';

\test_group('DiContainer config by definitions', static fn() => include 'di/index.php');
\test_group('DiContainer config by PHP attributes', static fn() => include 'attributes/index.php');

print PHP_EOL . 'time: ' . round(microtime(true) - $start, 4) . ' sec.';
print PHP_EOL . 'memory: ' . \mem() . PHP_EOL;
