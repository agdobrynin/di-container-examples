<?php

declare(strict_types=1);

namespace Attributes\Classes\Circular;

class CircularSecondClass
{
    public function __construct(public CircularFirstClass $class) {}
}
