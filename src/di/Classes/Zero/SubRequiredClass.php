<?php

declare(strict_types=1);

namespace Di\Classes\Zero;

class SubRequiredClass
{
    public function __invoke(): string
    {
        return 'Hello! I am class '.static::class;
    }
}
