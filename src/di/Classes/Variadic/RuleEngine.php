<?php

declare(strict_types=1);

namespace Di\Classes\Variadic;

class RuleEngine
{
    /**
     * @var RuleInterface[]
     */
    private array $rules;

    public function __construct(RuleInterface ...$rule)
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
