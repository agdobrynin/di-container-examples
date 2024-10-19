<?php

declare(strict_types=1);

namespace Di\Classes\Circular;

class CircularSecondClass
{
    public function __construct(public CircularThirdClass $class) {}
}
