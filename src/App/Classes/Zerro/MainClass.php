<?php

declare(strict_types=1);

namespace DiContainerExample\App\Classes\Zerro;

class MainClass
{
    public function __construct(public RequiredClass $class)
    {
    }
}
