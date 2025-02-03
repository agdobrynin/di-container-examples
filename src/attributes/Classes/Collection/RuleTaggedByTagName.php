<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

use Kaspi\DiContainer\Attributes\TaggedAs;

class RuleTaggedByTagName
{
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(
        #[TaggedAs('tags.validation.rules')]
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
