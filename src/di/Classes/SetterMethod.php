<?php

declare(strict_types=1);

namespace Di\Classes;


use Di\Classes\Collection\RuleInterface;

final class SetterMethod
{
    /** @var RuleInterface[]  */
    private array $rules = [];

    /**
     * @return RuleInterface[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    public function addRule(RuleInterface $rule): void
    {
        $this->rules[] = $rule;
    }
}
