<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

use Kaspi\DiContainer\Attributes\Tag;

#[Tag('tags.validation.rules', priority: 1_000)]
class RuleTrim implements RuleInterface
{
    public function validate(string $text): string
    {
        return \trim($text);
    }

    public static function getPriorityDefaultMethod(): string
    {
        return 'validation:1000';
    }
}
