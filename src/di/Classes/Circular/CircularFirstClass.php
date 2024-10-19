<?php

declare(strict_types=1);

namespace Di\Classes\Circular;

class CircularFirstClass
{
    public function __construct(public CircularSecondClass $class) {}
}
