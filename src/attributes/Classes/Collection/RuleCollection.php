<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

use Kaspi\DiContainer\Attributes\Inject;

class RuleCollection
{
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(
        #[Inject('services.rule-collection-lazy')]
        private readonly iterable $rules
    ) {}

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
