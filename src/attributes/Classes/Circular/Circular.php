<?php

declare(strict_types=1);

namespace Attributes\Classes\Circular;

class Circular
{
    public function __construct(public CircularInjectInterface $class) {}
}
