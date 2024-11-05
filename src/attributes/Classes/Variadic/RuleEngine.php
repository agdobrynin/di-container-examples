<?php

declare(strict_types=1);

namespace Attributes\Classes\Variadic;

use Kaspi\DiContainer\Attributes\Inject;

class RuleEngine
{
    /**
     * @var RuleInterface[]
     */
    private array $rules;

    public function __construct(
        #[Inject(RuleTrim::class)]
        #[Inject(RuleMinMax::class, arguments: ['min' => 10, 'max' => 100])]
        #[Inject(RuleEmail::class)]
        RuleInterface ...$rule
    )
    {
        $this->rules = $rule;
    }

    public function validate(string $text): string
    {
        return \array_reduce($this->rules, static function (string $carry, RuleInterface $rule) {
            return $rule->validate($carry);
        }, $text);
    }
}
