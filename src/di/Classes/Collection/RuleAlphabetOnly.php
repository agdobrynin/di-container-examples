<?php

declare(strict_types=1);

namespace Di\Classes\Collection;

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

    public static function getPriorityDefaultMethod(): int
    {
        return 1_000;
    }
}
