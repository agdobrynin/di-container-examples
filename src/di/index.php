<?php
declare(strict_types=1);

use Di\Classes\Circular\CircularFirstClass;
use Di\Classes\ClassFirst;
use Di\Classes\ClassInterface;
use Di\Classes\ClassUsers;
use Di\Classes\ClassWithEmptyType;
use Di\Classes\ClassWithUnionType;
use Di\Classes\MyEmployers;
use Di\Classes\MyLogger;
use Di\Classes\MyUsers;
use Di\Classes\Person;
use Di\Classes\Travel;
use Di\Classes\Variadic\RuleEngine;
use Di\Classes\Variadic\RuleException;
use Di\Classes\Zero\MainClass;
use Di\Classes\Zero\RequiredClass;
use Di\Classes\Zero\SubRequiredClass;
use Kaspi\DiContainer\DiContainerFactory;
use Kaspi\DiContainer\Exception\CallCircularDependencyException;
use Kaspi\DiContainer\Interfaces\DiContainerInterface;
use Psr\Log\LoggerInterface;

$container = (new DiContainerFactory())->make(
    require __DIR__ . '/di_config.php'
);

$rand = mt_rand();
(static function (ClassUsers $classUsers, string $name) use ($rand) {
    print \test_title('Testcase #1');

    $classUsers->createTable();

    assert($classUsers->addUser($name));
    assert(preg_match('/^\d+ \| John #\d+$/', implode(' | ', $classUsers->getUser($name))));

    print test_title('Success', '✅', 0);
})($container->get(ClassUsers::class), 'John #' . $rand);

(static function (MyUsers $users, MyEmployers $employers) {
    print \test_title('Testcase #2');

    assert($users->users === ['user1', 'user2']);
    assert($employers->employers === ['user1', 'user2']);

    print test_title('Success', '✅', 0);
})($container->get(MyUsers::class), $container->get(MyEmployers::class));

(static function (MyLogger $myLogger) {
    print \test_title('Testcase #3 - resolve by class');

    assert($myLogger->logger() instanceof LoggerInterface);
    assert($myLogger->logger()->getName() === 'app-logger');

    print test_title('Success', '✅', 0);
})($container->get(MyLogger::class));

(static function (ClassInterface $class) {
    print \test_title('Testcase #4 resolve by interface');

    assert($class instanceof ClassInterface);
    assert($class instanceof ClassFirst);
    assert($class->file() === __DIR__ . '/../../var/log.log');

    print test_title('Success', '✅', 0);
})($container->get(ClassInterface::class));

(static function (MainClass $mainClass) {
    print \test_title('Testcase #5 - zero dependency config');

    assert($mainClass->class instanceof RequiredClass);
    assert($mainClass->class->class instanceof SubRequiredClass);
    assert(str_starts_with(($mainClass->class->class)(), 'Hello! I am class '));

    print test_title('Success', '✅', 0);
})($container->get(MainClass::class));

(static function (Travel $travel) {
    print \test_title('Testcase #6 - resolve by argument name');
    assert($travel->travelFrom === 'Earth');
    assert($travel->travelTo === 'Moon');
    assert($travel->travelOptions->speed === 10);
    assert($travel->travelOptions->gravity === 'low');

    print test_title('Success', '✅', 0);
})($container->get(Travel::class));

(static function (Person $person) {
    print \test_title('Testcase #7 - resolve by DiFactoryInterface');
    assert($person->name === 'Piter');
    assert($person->age === 22);

    print test_title('Success', '✅', 0);
})($container->get(Person::class));

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #8 call method');

    assert($container->call([ClassFirst::class, 'file']) === __DIR__ . '/../../var/log.log');

    print test_title('Success', '✅', 0);
})($container);

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #9 call method by callback with autowiring');
    $f = static fn (MyLogger $myLogger): LoggerInterface => $myLogger->logger();

    assert($container->call($f) instanceof LoggerInterface);

    print test_title('Success', '✅', 0);
})($container);

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #10 catch circular call.');

    try {
        $container->get(CircularFirstClass::class);
    } catch (CallCircularDependencyException) {
        print test_title('Success', '✅', 0);
    }
})($container);

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #11 resolve non type hint argument.');

    assert($container->get(ClassWithEmptyType::class)->dependency instanceof Travel);

    print test_title('Success', '✅', 0);
})($container);

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #12 resolve from union type.');

    assert($container->get(ClassWithUnionType::class)->dependency instanceof MyUsers);

    print test_title('Success', '✅', 0);
})($container);

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #13 variadic arguments.');

    try {
        $container->get(RuleEngine::class)->validate('a@a.com');
    } catch (RuleException $exception) {
        \assert($exception->getMessage() === 'Length must be between 10 and 100.');
        print test_title('catch ', '     🌵', 0);
    }

    try {
        $container->get(RuleEngine::class)->validate('   a@a.com       ');
    } catch (RuleException $exception) {
        \assert($exception->getMessage() === 'Length must be between 10 and 100.');
        print test_title('catch ', '     🌵', 0);
    }

    try {
        $container->get(RuleEngine::class)->validate('Lorem ipsum dolor sit amet');
    } catch (RuleException $exception) {
        \assert(str_starts_with($exception->getMessage(), 'Not a valid email'));
        print test_title('catch ', '     🌵', 0);
    }

    \assert('alex.moon@gmail.com' === $container->get(RuleEngine::class)->validate('    alex.moon@gmail.com   '));
    print test_title('valid', '     ✔ ', 0);


    print test_title('Success', '✅', 0);
})($container);
