<?php
declare(strict_types=1);

use Di\Classes\ClassInterface;
use Di\Classes\ClassUsers;
use Di\Classes\MyEmployers;
use Di\Classes\MyLogger;
use Di\Classes\MyUsers;
use Di\Classes\Zero\MainClass;
use Kaspi\DiContainer\DiContainerFactory;
use Psr\Log\LoggerInterface;

$start = microtime(true);

require_once __DIR__ . '/../../vendor/autoload.php';

$container = DiContainerFactory::make(
    require __DIR__ . '/di_config.php'
);

$header = static fn(string $title) => "\n🧪 {$title}\n " . str_repeat('-', 20) . "\n";

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

(static function (MainClass $mainClass) use ($header) {
    print $header('Testcase #5 - zero dependency config');

    var_dump($mainClass);
})($container->get(MainClass::class));

print PHP_EOL . 'time: ' . round(microtime(true) - $start, 4) . ' sec.' . PHP_EOL;
