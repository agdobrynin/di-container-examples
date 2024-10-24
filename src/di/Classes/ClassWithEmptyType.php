<?php

declare(strict_types=1);

namespace Di\Classes;

class ClassWithEmptyType
{
    public function __construct(public $dependency) {}
}
