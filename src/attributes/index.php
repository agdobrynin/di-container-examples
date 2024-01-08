<?php

declare(strict_types=1);


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

    var_dump($myClass->pdo instanceof PDO);
})($container->get(MyClass::class));

(static function (MyUsers $myUsers, MyEmployers $myEmployers) {
    print test_title('Test # 2 resolve build on argument');

    var_dump(MyUsers::class, $myUsers->users);
    var_dump(MyEmployers::class, $myEmployers->employers);

})($container->get(MyUsers::class), $container->get(MyEmployers::class));

(static function (MyLogger $myLogger) {
    print test_title('Test #3 resolve argument by interface');

    var_dump(
        $myLogger->customLogger->loggerFile(),
        $myLogger
    );

    $myLogger->logger->debug('Yes!');
})($container->get(MyLogger::class));
