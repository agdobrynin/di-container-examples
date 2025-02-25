<?php

declare(strict_types=1);

namespace Di\Classes;

class ClassWithUnionTypeWithException
{
    public function __construct(public MyUsers|MyEmployers $dependency) {}
}
