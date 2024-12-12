<?php
// Config services for test collection injected by config with php definitions only.

use Di\Classes\Collection\RuleAlphabetOnly;
use Di\Classes\Collection\RuleCollection;
use Di\Classes\Collection\RuleMinMax;
use Di\Classes\Collection\RuleTrim;
use function Kaspi\DiContainer\diAutowire;
use function Kaspi\DiContainer\diGet;

return static function (): \Generator {
    yield diAutowire(RuleMinMax::class)
        ->bindArguments(min: 10, max: 255);

    yield 'services.rule-collection' => static fn(
        RuleTrim         $ruleTrim,
        RuleMinMax       $ruleMinMax,
        RuleAlphabetOnly $ruleAlphabetOnly,
    ) => func_get_args();

    yield diAutowire(RuleCollection::class)
        ->bindArguments(
            rules: diGet('services.rule-collection')
        );
};
