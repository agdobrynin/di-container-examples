<?php

declare(strict_types=1);

namespace Attributes\Classes\Collection;

interface RuleInterface
{
    /**
     * @throws RuleException
     */
    public function validate(string $text): string;
}
