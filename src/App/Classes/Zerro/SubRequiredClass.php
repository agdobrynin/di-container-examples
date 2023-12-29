<?php

declare(strict_types=1);

namespace DiContainerExample\App\Classes\Zerro;

class SubRequiredClass
{
    public function __invoke(): string
    {
        return 'Hello! I am class '.static::class;
    }
}
