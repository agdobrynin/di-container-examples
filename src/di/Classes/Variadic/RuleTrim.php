<?php

declare(strict_types=1);

namespace Di\Classes\Variadic;

class RuleTrim implements RuleInterface
{
    public function validate(string $text): string
    {
        return \trim($text);
    }
}
