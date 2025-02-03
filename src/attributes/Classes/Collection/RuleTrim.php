<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

use Kaspi\DiContainer\Attributes\Tag;

#[Tag('tags.validation.rules', ['priority' => 1000])]
class RuleTrim implements RuleInterface
{
    public function validate(string $text): string
    {
        return \trim($text);
    }
}
