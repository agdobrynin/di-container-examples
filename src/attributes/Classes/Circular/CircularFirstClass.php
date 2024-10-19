<?php

declare(strict_types=1);

namespace Attributes\Classes\Circular;

class CircularFirstClass
{
    public function __construct(public CircularSecondClass $class) {}
}
