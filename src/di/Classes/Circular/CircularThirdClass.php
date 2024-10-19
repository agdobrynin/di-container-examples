<?php

declare(strict_types=1);

namespace Di\Classes\Circular;

class CircularThirdClass
{
    public function __construct(public CircularFirstClass $class) {}
}
