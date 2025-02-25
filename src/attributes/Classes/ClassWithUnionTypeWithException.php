<?php

declare(strict_types=1);

namespace Attributes\Classes;

class ClassWithUnionTypeWithException
{
    public function __construct(public MyUsers|MyEmployers $dependency) {}
}
