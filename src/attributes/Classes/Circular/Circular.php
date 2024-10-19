<?php

declare(strict_types=1);

namespace Attributes\Classes\Circular;

use Kaspi\DiContainer\Attributes\Inject;

class Circular
{
    public function __construct(
        #[Inject(CircularFirstClass::class)]
        public CircularInjectInterface $class
    ) {}
}
