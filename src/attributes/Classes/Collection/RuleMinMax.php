<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

use Kaspi\DiContainer\Attributes\Tag;

#[Tag('tags.validation.rules', priority: 100)]
class RuleMinMax implements RuleInterface
{
    public function __construct(private readonly int $min = 5, private readonly int $max = 50)
    {
    }

    public function validate(string $text): string
    {
        $len = strlen($text);

        return $len > $this->min && $len < $this->max
            ? $text
            : throw new RuleException('Length must be between ' . $this->min . ' and ' . $this->max . '.');
    }

    public static function getPriorityDefaultMethod(): string
    {
        return 'validation:0100';
    }
}
