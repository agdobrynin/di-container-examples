<?php

declare(strict_types=1);


use Attributes\Classes\CustomLoggerInterface;
use Attributes\Classes\MyClass;
use Attributes\Classes\MyEmployers;
use Attributes\Classes\MyLogger;
use Attributes\Classes\MyUsers;
use Kaspi\DiContainer\DiContainerFactory;

$container = (new DiContainerFactory())->make(
    require __DIR__ . '/di_config.php'
);

(static function (MyClass $myClass) {
    print test_title('Test # 1 resolve build on argument');

    assert($myClass->pdo instanceof PDO);
})($container->get(MyClass::class));

(static function (MyUsers $myUsers, MyEmployers $myEmployers) {
    print test_title('Test # 2 resolve build on argument');

    assert(['user1', 'user2'] === $myUsers->users);
    assert(['user1', 'user2'] === $myEmployers->employers);
})($container->get(MyUsers::class), $container->get(MyEmployers::class));

(static function (MyLogger $myLogger) {
    print test_title('Test #3 resolve argument by interface');

    assert($myLogger instanceof MyLogger);
    assert($myLogger->customLogger instanceof CustomLoggerInterface);
    assert($myLogger->customLogger->loggerFile() ===  __DIR__.'/../../var/app.log');

    $myLogger->logger->debug('Yes!');
})($container->get(MyLogger::class));
