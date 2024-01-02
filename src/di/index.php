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


(static function (ClassUsers $classUsers, string $name) {
    print test_title('Testcase #1');

    $classUsers->createTable();

    if ($classUsers->addUser($name)) {
        var_dump($classUsers->getUser($name));
    }
})($container->get(ClassUsers::class), 'John #' . mt_rand());

(static function (MyUsers $users, MyEmployers $employers) {
    print test_title('Testcase #2');

    var_dump($users, $employers);
})($container->get(MyUsers::class), $container->get(MyEmployers::class));

(static function (MyLogger $myLogger) {
    print test_title('Testcase #3');

    var_dump($myLogger->logger() instanceof LoggerInterface);
})($container->get(MyLogger::class));

(static function (ClassInterface $class) {
    print test_title('Testcase #4');

    var_dump($class->file(), get_class($class));
})($container->get(ClassInterface::class));

(static function (MainClass $mainClass) {
    print test_title('Testcase #5 - zero dependency config');

    var_dump($mainClass);
})($container->get(MainClass::class));

print PHP_EOL . 'time: ' . round(microtime(true) - $start, 4) . ' sec.' . PHP_EOL;
