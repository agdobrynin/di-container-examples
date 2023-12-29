<?php

declare(strict_types=1);

namespace App\Classes\Zero;

class RequiredClass
{
    public function __construct(public SubRequiredClass $class)
    {
    }
}
