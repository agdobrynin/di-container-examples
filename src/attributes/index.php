<?php

declare(strict_types=1);

use Attributes\Classes\AppLogger;
use Attributes\Classes\Circular\Circular;
use Attributes\Classes\ClassWithUnionTypeByInject;
use Attributes\Classes\ClassWithUnionTypeWithException;
use Attributes\Classes\Collection\RuleAlphabetOnly;
use Attributes\Classes\Collection\RuleCollection;
use Attributes\Classes\Collection\RuleMinMax;
use Attributes\Classes\Collection\RuleTaggedByInterface;
use Attributes\Classes\Collection\RuleTaggedByInterfacePriorityDefaultMethod;
use Attributes\Classes\Collection\RuleTaggedByTagName;
use Attributes\Classes\Collection\RuleTrim;
use Attributes\Classes\CustomLoggerInterface;
use Attributes\Classes\DiFactoryOnProperty;
use Attributes\Classes\MyClass;
use Attributes\Classes\MyEmployers;
use Attributes\Classes\MyLogger;
use Attributes\Classes\MyUsers;
use Attributes\Classes\Person;
use Attributes\Classes\SetterImmutableMethod;
use Attributes\Classes\SetterMethod;
use Attributes\Classes\TaggedKeys\One;
use Attributes\Classes\TaggedKeys\TaggedCollection;
use Attributes\Classes\TaggedKeys\Two;
use Attributes\Classes\Variadic\RuleEngine;
use Attributes\Classes\Variadic\RuleException;
use Kaspi\DiContainer\DefinitionsLoader;
use Kaspi\DiContainer\DiContainerConfig;
use Kaspi\DiContainer\DiContainerFactory;
use Kaspi\DiContainer\Exception\CallCircularDependencyException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

$definitions = (new DefinitionsLoader())
    ->load(...\glob(__DIR__ . '/config/*.php'))
    ->import('Attributes\Classes\\', __DIR__ . '/Classes/')
    ->definitions();

$container = (new DiContainerFactory(
    new DiContainerConfig(
        useZeroConfigurationDefinition: false
    )
))
    ->make($definitions);

(static function (MyClass $myClass) {
    print test_title('Test # 1 resolve build on argument');

    assert($myClass->pdo instanceof PDO);
    // PDO configured by diAutowire helper setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER)
    assert($myClass->pdo->getAttribute(PDO::ATTR_CASE) === PDO::CASE_UPPER);

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
    assert($myLogger->customLogger->loggerFile() === realpath(__DIR__ . '/../../var/app.log'));

    $myLogger->logger->debug('Yes!');

    print test_title('Success', '✅', 0);
})($container->get(MyLogger::class));

(static function (Person $person) {
    print test_title('Test #4 resolve by DiFactoryInterface with php attributes');

    assert($person->name === 'Piter');
    assert($person->surname === 'Good');
    assert($person->age === 30);

    print test_title('Success', '✅', 0);
})($container->get(Person::class));

(static function (DiFactoryOnProperty $personOnFactory) {
    print test_title('Test #5 resolve property by DiFactoryInterface with php attributes');

    assert($personOnFactory->person->name === 'Piter');
    assert($personOnFactory->person->surname === 'Good');
    assert($personOnFactory->person->age === 30);

    print test_title('Success', '✅', 0);
})($container->get(DiFactoryOnProperty::class));

(static function (ContainerInterface $container) {
    print \test_title('Testcase #6 catch circular call when resolve via interface.');

    try {
        $container->get(Circular::class);
    } catch (CallCircularDependencyException) {
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container);

(static function (ContainerInterface $container) {
    print \test_title('Testcase #7 testcase for union type hint with exception.');
    print \test_title('Concrete type hint in union type.', 'ℹ ', 0);

    try {
        $container->get(ClassWithUnionTypeWithException::class);
    } catch (ContainerExceptionInterface $exception) {
        \assert(str_contains($exception->getMessage(), 'Please specify the parameter type for the argument "$dependency"'));

        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container);


(static function (ClassWithUnionTypeByInject $classWithUnionTypeByInject) {
    print \test_title('Testcase #8 testcase for union type hint with Inject attribute.');
    print \test_title('Get injected type from union type hint.', 'ℹ ', 0);

    assert($classWithUnionTypeByInject->dependency instanceof MyEmployers);

    print test_title('Success', '✅', 0);
})($container->get(ClassWithUnionTypeByInject::class));

(static function (RuleEngine $ruleEngine) {
    print \test_title('Testcase #9 variadic arguments.');

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

(static function (RuleCollection $ruleCollection) {
    print \test_title('Testcase #10 Inject collection attribute.');

    $res = $ruleCollection
        ->validate('  My string with valid string  ');

    \assert('My string with valid string' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleCollection::class));

(static function (RuleCollection $ruleCollection) {
    print \test_title('Testcase #11 Inject collection attribute with failed validation.');

    try {
        $ruleCollection->validate('\0123administrator');
    } catch (\Attributes\Classes\Collection\RuleException $e) {
        \assert(str_starts_with($e->getMessage(), 'Invalid string. String must contain only letters'));
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get(RuleCollection::class));

(static function (RuleTaggedByInterface $ruleTaggedBy) {
    print \test_title('Testcase #12 Tagged collection by interface with failed validation.');

    try {
        $ruleTaggedBy->validate('\0123administrator');
    } catch (\Attributes\Classes\Collection\RuleException $e) {
        \assert(str_starts_with($e->getMessage(), 'Invalid string. String must contain only letters'));
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterface::class));

(static function (RuleTaggedByInterface $ruleTaggedBy) {
    print \test_title('Testcase #13 Tagged collection by interface success validation.');

    $res = $ruleTaggedBy
        ->validate('  My string with valid string  ');

    \assert('My string with valid string' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterface::class));

(static function (RuleTaggedByTagName $ruleTaggedBy) {
    print \test_title('Testcase #14 Tagged collection by tag name with priority success validation.');

    $res = $ruleTaggedBy
        ->validate('  My string with valid string  ');

    \assert('My string with valid string' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByTagName::class));

(static function (RuleTaggedByInterfacePriorityDefaultMethod $validator) {
    print \test_title('Testcase #15 Tagged collection by tag name with priority by default method.');

    $res = $validator
        ->validate('   Lorem ipsum     ');

    \assert('Lorem ipsum' === $res);

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterfacePriorityDefaultMethod::class));

(static function (RuleTaggedByInterfacePriorityDefaultMethod $validator) {
    print \test_title('Testcase #16 Tagged collection by tag name with priority by default method failed.');

    try {
        $validator->validate('     Lo        ');
    } catch (\Attributes\Classes\Collection\RuleException $e) {
        \assert(str_starts_with($e->getMessage(), 'Length must be between'));
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get(RuleTaggedByInterfacePriorityDefaultMethod::class));

(static function (TaggedCollection $taggedCollection) {
    print \test_title('Testcase #17 Tagged collection with custom collection key.');

    // access by php-array
    \assert($taggedCollection->items['name.two'] instanceof Two);
    \assert($taggedCollection->items['name.one'] instanceof One);

    \assert(2 === $taggedCollection->items->count());

    // access by ContainerInterface
    \assert($taggedCollection->items->get('name.two') instanceof Two);
    \assert($taggedCollection->items->get('name.one') instanceof One);

    // catch exception
    try {
        $taggedCollection->items->get('name.three');
    } catch (NotFoundExceptionInterface $e) {
        \assert(str_starts_with($e->getMessage(), 'Definition "name.three" not found'));
        print test_title('catch exception', '     🧲', 0);
    }

    print test_title('Success', '✅', 0);
})($container->get(TaggedCollection::class));

(static function (SetterMethod $setterMethod) {
    print \test_title('Testcase #18 Use setter mutable method.');

    \assert(3 === count($setterMethod->getRules()));
    \assert($setterMethod->getRules()[0] instanceof RuleTrim);
    \assert($setterMethod->getRules()[1] instanceof RuleMinMax);
    \assert($setterMethod->getRules()[2] instanceof RuleAlphabetOnly);

    print test_title('Success', '✅', 0);
})($container->get(SetterMethod::class));

(static function (SetterImmutableMethod $setterImmutableMethod) {
    print \test_title('Testcase #19 Use setter immutable method.');

    \assert($setterImmutableMethod->getLogger() instanceof LoggerInterface);
    \assert($setterImmutableMethod->getLogger() instanceof AppLogger);
    \assert(!($setterImmutableMethod->getLogger() instanceof NullLogger));

    print test_title('Success', '✅', 0);
})($container->get(SetterImmutableMethod::class));
