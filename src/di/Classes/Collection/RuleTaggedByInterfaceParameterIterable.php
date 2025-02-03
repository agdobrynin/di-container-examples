<?php

declare(strict_types=1);

namespace Di\Classes\Collection;

class RuleTaggedByInterfaceParameterIterable
{
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(private readonly iterable $rules)
    {
    }

    /**
     * @throws RuleException
     */
    public function validate(string $str): string
    {
        foreach ($this->rules as $rule) {
            $str = $rule->validate($str);
        }

        return $str;
    }
}
