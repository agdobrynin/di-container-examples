<?php
// Config services for test collection injected by #[Inject('services.rule-collection')]

use Attributes\Classes\Collection\RuleAlphabetOnly;
use Attributes\Classes\Collection\RuleMinMax;
use Attributes\Classes\Collection\RuleTrim;
use function Kaspi\DiContainer\diAutowire;

return static function (): \Generator {
    yield diAutowire(RuleMinMax::class)
        ->bindArguments(min: 10, max: 255);

    yield 'services.rule-collection' => static fn(
        RuleTrim         $ruleTrim,
        RuleMinMax       $ruleMinMax,
        RuleAlphabetOnly $ruleAlphabetOnly,
    ) => func_get_args();
};
