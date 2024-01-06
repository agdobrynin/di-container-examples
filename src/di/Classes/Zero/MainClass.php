<?php

declare(strict_types=1);

namespace Di\Classes\Zero;

class MainClass
{
    public function __construct(public RequiredClass $class)
    {
    }
}
