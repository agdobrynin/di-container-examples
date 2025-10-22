<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Attributes\Classes\Collection\RuleAlphabetOnly;
use Attributes\Classes\Collection\RuleInterface;
use Attributes\Classes\Collection\RuleMinMax;
use Attributes\Classes\Collection\RuleTrim;
use Kaspi\DiContainer\Attributes\Autowire;
use Kaspi\DiContainer\Attributes\Setup;

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

    #[Setup('@'.RuleTrim::class)]
    #[Setup('@'.RuleMinMax::class)]
    #[Setup('@'.RuleAlphabetOnly::class)]
    public function addRule(RuleInterface $rule): void
    {
        $this->rules[] = $rule;
    }
}
