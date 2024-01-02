<?php

declare(strict_types=1);

namespace Di\Classes\Zero;

class RequiredClass
{
    public function __construct(public SubRequiredClass $class)
    {
    }
}
