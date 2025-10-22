<?php

declare(strict_types=1);

$start = microtime(true);

require_once __DIR__ . '/../vendor/autoload.php';

try {
    \test_group('DiContainer config by definitions', static fn() => include 'di/index.php');
    \test_group('DiContainer config by PHP attributes', static fn() => include 'attributes/index.php');
} catch (\AssertionError $exception) {
    print test_title('Assert failed','💥');
    print $exception;
} finally {
    print test_title('', '⏱');
    print PHP_EOL . 'time: ' . round(microtime(true) - $start, 4) . ' sec.';
    print PHP_EOL . 'memory: ' . \mem() . PHP_EOL;
}
