<?php
// Config services for test collection injected by config with php definitions only.

use Di\Classes\Collection\RuleAlphabetOnly;
use Di\Classes\Collection\RuleCollection;
use Di\Classes\Collection\RuleInterface;
use Di\Classes\Collection\RuleMinMax;
use Di\Classes\Collection\RuleTaggedByInterfaceParameterIterable;
use Di\Classes\Collection\RuleTaggedByTagNameParameterArray;
use Di\Classes\Collection\RuleTrim;
use function Kaspi\DiContainer\diAutowire;
use function Kaspi\DiContainer\diGet;
use function Kaspi\DiContainer\diTaggedAs;

return static function (): \Generator {
    yield diAutowire(RuleMinMax::class)
        ->bindArguments(min: 10, max: 255)
        ->bindTag('services.validation', ['priority' => 100]);

    yield 'services.rule-collection' => static fn(
        RuleTrim         $ruleTrim,
        RuleMinMax       $ruleMinMax,
        RuleAlphabetOnly $ruleAlphabetOnly,
    ) => func_get_args();

    yield diAutowire(RuleCollection::class)
        ->bindArguments(
            rules: diGet('services.rule-collection')
        );

    yield diAutowire(RuleAlphabetOnly::class)
        ->bindTag('services.validation', ['priority' => 1000]);

    yield diAutowire(RuleTrim::class)
        ->bindTag('services.validation', ['priority' => 0]);


    yield diAutowire(RuleTaggedByTagNameParameterArray::class)
        ->bindArguments(
            rules: diTaggedAs(tag: 'services.validation', isLazy: false)
        );

    yield diAutowire(RuleTaggedByInterfaceParameterIterable::class)
        ->bindArguments(
            rules: diTaggedAs(tag: RuleInterface::class)
        );
};
