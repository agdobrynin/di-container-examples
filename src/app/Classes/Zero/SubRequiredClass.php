<?php

declare(strict_types=1);

namespace App\Classes\Zero;

class SubRequiredClass
{
    public function __invoke(): string
    {
        return 'Hello! I am class '.static::class;
    }
}
