<?php

declare(strict_types=1);

namespace Di\Classes\Collection;

class RuleTaggedByTagNameParameterArray
{
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(private readonly array $rules)
    {
    }

    /**
     * @throws RuleException
     */
    public function validate(string $str): string
    {
        return \array_reduce(
            $this->rules,
            static fn(string $carry, RuleInterface $rule) => $rule->validate($carry),
            $str
        );
    }
}
