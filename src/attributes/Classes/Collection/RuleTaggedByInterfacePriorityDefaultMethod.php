<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

use Kaspi\DiContainer\Attributes\TaggedAs;

class RuleTaggedByInterfacePriorityDefaultMethod
{
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(
        #[TaggedAs(
            RuleInterface::class,
            priorityDefaultMethod: 'getPriorityDefaultMethod'
        )]
        private readonly iterable $rules
    )
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
