<?php

declare(strict_types=1);

namespace Di\Classes\Variadic;

class RuleEmail implements RuleInterface
{
    public function __construct(private readonly array|int $options = 0)
    {
    }

    public function validate(string $text): string
    {
        return \filter_var($text, FILTER_VALIDATE_EMAIL, $this->options)
            ?: throw new RuleException('Not a valid email: ' . $text);
    }
}
