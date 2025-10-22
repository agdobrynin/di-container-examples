<?php

declare(strict_types=1);

$start = microtime(true);

require_once __DIR__ . '/../vendor/autoload.php';

// Clear temporary files.
if (array_key_exists('c', getopt('c'))) {
    foreach (glob(__DIR__ . '/../var/*') as $file) {
        unlink($file);
    }
}

try {
    \test_group('DiContainer config by definitions', static fn() => include 'di/index.php');
    \test_group('DiContainer config by PHP attributes', static fn() => include 'attributes/index.php');
} catch (Throwable $exception) {
    print test_title('Assert failed','🖐 ');
    print test_title('Throwable: '. $exception::class, '🧪');
    print $exception;
    print test_title(icon: '💥');
} finally {
    print PHP_EOL . 'time: ⏱' . round(microtime(true) - $start, 4) . ' sec.';
    print PHP_EOL . 'memory: ' . \mem() . PHP_EOL;
}
