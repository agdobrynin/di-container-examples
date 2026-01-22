<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Attributes\Classes\Collection\RuleAlphabetOnly;
use Attributes\Classes\Collection\RuleInterface;
use Attributes\Classes\Collection\RuleMinMax;
use Attributes\Classes\Collection\RuleTrim;
use Kaspi\DiContainer\Attributes\Setup;
use Kaspi\DiContainer\DiDefinition\DiDefinitionGet as DiGet;

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

    #[Setup(new DiGet(RuleTrim::class))]
    #[Setup(new DiGet(RuleMinMax::class))]
    #[Setup(new DiGet(RuleAlphabetOnly::class))]
    public function addRule(RuleInterface $rule): void
    {
        $this->rules[] = $rule;
    }
}
