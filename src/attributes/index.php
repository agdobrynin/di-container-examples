<?php

declare(strict_types=1);


use Attributes\Classes\Circular\Circular;
use Attributes\Classes\CustomLoggerInterface;
use Attributes\Classes\DiFactoryOnProperty;
use Attributes\Classes\MyClass;
use Attributes\Classes\MyEmployers;
use Attributes\Classes\MyLogger;
use Attributes\Classes\MyUsers;
use Attributes\Classes\Person;
use Kaspi\DiContainer\DiContainerFactory;
use Kaspi\DiContainer\Exception\CallCircularDependency;
use Psr\Container\ContainerInterface;

$container = (new DiContainerFactory())->make(
    require __DIR__ . '/di_config.php'
);

(static function (MyClass $myClass) {
    print test_title('Test # 1 resolve build on argument');

    assert($myClass->pdo instanceof PDO);

    print test_title('Success', '✅', 0);
})($container->get(MyClass::class));

(static function (MyUsers $myUsers, MyEmployers $myEmployers) {
    print test_title('Test # 2 resolve build on argument');

    assert(['user1', 'user2'] === $myUsers->users);
    assert(['user1', 'user2'] === $myEmployers->employers);

    print test_title('Success', '✅', 0);
})($container->get(MyUsers::class), $container->get(MyEmployers::class));

(static function (MyLogger $myLogger) {
    print test_title('Test #3 resolve argument by interface');

    assert($myLogger instanceof MyLogger);
    assert($myLogger->customLogger instanceof CustomLoggerInterface);
    assert($myLogger->customLogger->loggerFile() ===  __DIR__.'/../../var/app.log');

    $myLogger->logger->debug('Yes!');

    print test_title('Success', '✅', 0);
})($container->get(MyLogger::class));

(static function (Person $person) {
    print test_title('Test #4 resolve by DiFactoryInterface with php attributes');

    assert($person->name === 'Piter');
    assert($person->surname === 'Good');
    assert($person->age ===  30);

    print test_title('Success', '✅', 0);
})($container->get(Person::class));

(static function (DiFactoryOnProperty $personOnFactory) {
    print test_title('Test #5 resolve property by DiFactoryInterface with php attributes');

    assert($personOnFactory->person->name === 'Piter');
    assert($personOnFactory->person->surname === 'Good');
    assert($personOnFactory->person->age ===  30);

    print test_title('Success', '✅', 0);
})($container->get(DiFactoryOnProperty::class));

(static function (ContainerInterface $container) {
    print \test_title('Testcase #6 catch circular call when resolve via interface.');

    try {
        $container->get(Circular::class);
    } catch (CallCircularDependency) {
        print test_title('Success', '✅', 0);
    }
})($container);
