<?php
// Config services for test collection injected by #[Inject('services.rule-collection')]

use Attributes\Classes\Collection\RuleAlphabetOnly;
use Attributes\Classes\Collection\RuleMinMax;
use Attributes\Classes\Collection\RuleTrim;
use function Kaspi\DiContainer\diAutowire;

return static function (): \Generator {
    yield diAutowire(RuleTrim::class);

    yield diAutowire(RuleMinMax::class)
        ->bindArguments(min: 10, max: 255);

    yield diAutowire(RuleAlphabetOnly::class);

    yield 'services.rule-collection' => static fn(
        RuleTrim         $ruleTrim,
        RuleMinMax       $ruleMinMax,
        RuleAlphabetOnly $ruleAlphabetOnly,
    ) => func_get_args();

    yield 'services.rule-collection-lazy' => static function(Psr\Container\ContainerInterface $container): \Generator {
        yield $container->get(RuleTrim::class);

        yield $container->get(RuleMinMax::class);

        yield $container->get(RuleAlphabetOnly::class);
    };
};
