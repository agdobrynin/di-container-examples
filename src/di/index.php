<?php
declare(strict_types=1);

use Di\Classes\Circular\CircularFirstClass;
use Di\Classes\ClassFirst;
use Di\Classes\ClassInterface;
use Di\Classes\ClassUsers;
use Di\Classes\ClassWithEmptyType;
use Di\Classes\ClassWithUnionType;
use Di\Classes\Collection\RuleCollection;
use Di\Classes\Collection\RuleTaggedByInterfaceParameterIterable;
use Di\Classes\Collection\RuleTaggedByInterfacePriorityDefaultMethod;
use Di\Classes\Collection\RuleTaggedByTagNameParameterArray;
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
use Kaspi\DiContainer\DefinitionsLoader;
use Kaspi\DiContainer\DiContainerFactory;
use Kaspi\DiContainer\Exception\CallCircularDependencyException;
use Kaspi\DiContainer\Interfaces\DiContainerInterface;
use Psr\Log\LoggerInterface;

$definitions = (new DefinitionsLoader())->load(
    false,
    __DIR__ . '/config/services.php',
    __DIR__ . '/config/service_employer.php',
    __DIR__ . '/config/service_user.php',
    __DIR__ . '/config/simple-data.php',
    __DIR__ . '/config/service_collection.php',
);
$container = (new DiContainerFactory())->make($definitions->definitions());

$rand = mt_rand();

(static function (ClassUsers $classUsers, string $name) {
    print \test_title('Testcase #1');

    $classUsers->createTable();

    assert($classUsers->addUser($name));
    assert(preg_match('/^\d+ \| John #\d+$/', implode(' | ', $classUsers->getUser($name))));
    // PDO configure get column name as uppercase
    assert(['ID', 'NAME'] === \array_keys($classUsers->getUser($name)));

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
    assert($class->file() === realpath(__DIR__ . '/../../var/log.log'));

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

    assert($container->call([ClassFirst::class, 'file']) === realpath(__DIR__ . '/../../var/log.log'));

    print test_title('Success', '✅', 0);
})($container);

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #9 call method by callback with autowiring');
    $f = static fn(MyLogger $myLogger): LoggerInterface => $myLogger->logger();

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

(static function (ClassWithEmptyType $classWithEmptyType) {
    print \test_title('Testcase #11 resolve non type hint argument.');

    assert($classWithEmptyType->dependency instanceof Travel);

    print test_title('Success', '✅', 0);
})($container->get(ClassWithEmptyType::class));

(static function (DiContainerInterface $container) {
    print \test_title('Testcase #12 resolve from union type.');

    assert($container->get(ClassWithUnionType::class)->dependency instanceof MyUsers);

    print test_title('Success', '✅', 0);
})($container);

(static function (RuleEngine $ruleEngine) {
    print \test_title('Testcase #13 variadic arguments by parameter name.');

    try {
        $ruleEngine->validate('a@a.com');
    } catch (RuleException $exception) {
        \assert($exception->getMessage() === 'Length must be between 10 and 100.');
        print test_title('catch exception', '     🧲', 0);
    }

    try {
        $ruleEngine->validate('   a@a.com       ');
    } catch (RuleException $exception) {
        \assert($exception->getMessage() === 'Length must be between 10 and 100.');
        print test_title('catch exception', '     🧲', 0);
    }

    try {
        $ruleEngine->validate('Lorem ipsum dolor sit amet');
    } catch (RuleException $exception) {
        \assert(str_starts_with($exception->getMessage(), 'Not a valid email'));
        print test_title('catch exception', '     🧲', 0);
    }

    \assert('alex.moon@gmail.com' === $ruleEngine->validate('    alex.moon@gmail.com   '));
    print test_title('valid', '     ✔ ', 0);


    print test_title('Success', '✅', 0);
})($container->get(RuleEngine::class));

(static function (RuleEngine $myRule) {
    print \test_title('Testcase #14 variadic arguments by parameter index.');

    \assert('my text printed' === $myRule->validate('  my text printed '));
    print test_title('valid', '     ✔ ', 0);

    try {
        $myRule->validate('o');
    } catch (RuleException $exception) {
        \assert($exception->getMessage() === 'Length must be between 4 and 23.');
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get('services.rules.may-rule'));

(static function (RuleCollection $ruleCollection) {
    print \test_title('Testcase #15 collection.');

    $res = $ruleCollection->validate('  My string with valid string  ');

    \assert('My string with valid string' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleCollection::class));

(static function (RuleCollection $ruleCollection) {
    print \test_title('Testcase #16 collection with failed validation.');

    try {
        $ruleCollection->validate('\0123administrator');
    } catch (\Di\Classes\Collection\RuleException $e) {
        \assert(
            $e->getMessage() === 'Invalid string. String must contain only letters. Got: \'\0123administrator\''
        );
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get(RuleCollection::class));

(static function (RuleTaggedByTagNameParameterArray $taggedByTagNameParameterArray) {
    print \test_title('Testcase #17 collection tagged by tag name failed validation.');

    try {
        $taggedByTagNameParameterArray->validate('\0123administrator');
    } catch (\Di\Classes\Collection\RuleException $e) {
        \assert(
            $e->getMessage() === 'Invalid string. String must contain only letters. Got: \'\0123administrator\''
        );
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByTagNameParameterArray::class));

(static function (RuleTaggedByTagNameParameterArray $taggedByTagNameParameterArray) {
    print \test_title('Testcase #18 collection tagged by tag name successful.');

    $res = $taggedByTagNameParameterArray->validate(' admin of site   ');

    \assert('admin of site' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByTagNameParameterArray::class));

(static function (RuleTaggedByInterfaceParameterIterable $taggedByInterfaceParameterIterable) {
    print \test_title('Testcase #19 collection tagged by interface name successful.');

    $res = $taggedByInterfaceParameterIterable->validate(' admin of site   ');

    \assert('admin of site' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterfaceParameterIterable::class));

(static function (RuleTaggedByInterfaceParameterIterable $taggedByInterfaceParameterIterable) {
    print \test_title('Testcase #20 collection tagged by interface name false positive.');

    // Rule for min max - false positive because trim rule call latree
    $res = $taggedByInterfaceParameterIterable->validate('      ada       ');
    \assert('ada' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterfaceParameterIterable::class));

(static function (RuleTaggedByInterfacePriorityDefaultMethod $taggedByInterfaceParameterIterable) {
    print \test_title('Testcase #21 collection tagged by interface with priority by default method.');

    try {
        $taggedByInterfaceParameterIterable->validate('      ada       ');
    } catch (\Di\Classes\Collection\RuleException $e) {
        \assert(
            $e->getMessage() === 'Length must be between 10 and 255.'
        );
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterfacePriorityDefaultMethod::class));

(static function (RuleTaggedByInterfacePriorityDefaultMethod $taggedByInterfaceParameterIterable) {
    print \test_title('Testcase #22 collection tagged by interface with priority by default method.');

    $res = $taggedByInterfaceParameterIterable->validate('      Lorem ipsum       ');
    \assert('Lorem ipsum' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterfacePriorityDefaultMethod::class));