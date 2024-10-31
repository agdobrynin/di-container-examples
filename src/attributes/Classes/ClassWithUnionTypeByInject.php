<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;

class ClassWithUnionTypeByInject
{
    public function __construct(
        #[Inject(MyEmployers::class)]
        public MyUsers|MyEmployers $dependency
    ) {}
}
