<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

use Kaspi\DiContainer\Attributes\Tag;

#[Tag('tags.validation.rules', ['priority' => 10])]
class RuleAlphabetOnly implements RuleInterface
{

    public function __construct(private readonly string $regexp = '/^[a-zA-Z ]+$/i')
    {
    }

    public function validate(string $text): string
    {
        if (preg_match($this->regexp, $text)) {
            return $text;
        }

        throw new RuleException('Invalid string. String must contain only letters. Got: \''.$text.'\'');
    }
}
