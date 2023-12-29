<?php
declare(strict_types=1);

use DiContainerExample\App\Classes\ClassInterface;
use DiContainerExample\App\Classes\ClassUsers;
use DiContainerExample\App\Classes\MyEmployers;
use DiContainerExample\App\Classes\MyLogger;
use DiContainerExample\App\Classes\MyUsers;
use Kaspi\DiContainer\DiContainerFactory;
use Psr\Log\LoggerInterface;

$start = microtime(true);

require_once __DIR__ . '/../vendor/autoload.php';


$definitions = require __DIR__ . '/di_config.php';

$container = DiContainerFactory::make($definitions);

$header = static fn(string $title) => PHP_EOL . $title . PHP_EOL .
    str_repeat('-', 20) . PHP_EOL;

(static function (ClassUsers $classUsers, string $name) use ($header) {
    print $header('Testcase #1');

    $classUsers->createTable();

    if ($classUsers->addUser($name)) {
        var_dump($classUsers->getUser($name));
    }
})($container->get(ClassUsers::class), 'John #' . mt_rand());

(static function (MyUsers $users, MyEmployers $employers) use ($header) {
    print $header('Testcase #2');

    var_dump($users, $employers);
})($container->get(MyUsers::class), $container->get(MyEmployers::class));

(static function (MyLogger $myLogger) use ($header) {
    print $header('Testcase #3');

    var_dump($myLogger->logger() instanceof LoggerInterface);
})($container->get(MyLogger::class));

(static function (ClassInterface $class) use ($header) {
    print $header('Testcase #4');
    var_dump($class->file(), get_class($class));
})($container->get(ClassInterface::class));

print PHP_EOL . 'time: ' . round(microtime(true) - $start, 4) . ' sec.' . PHP_EOL;
