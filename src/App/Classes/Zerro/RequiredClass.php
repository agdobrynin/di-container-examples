<?php

declare(strict_types=1);

namespace DiContainerExample\App\Classes\Zerro;

class RequiredClass
{
    public function __construct(public SubRequiredClass $class)
    {
    }
}
