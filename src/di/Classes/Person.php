<?php

declare(strict_types=1);

namespace Di\Classes;

final class Person
{
    public function __construct(
        public readonly string $name,
        public readonly int $age,
    ){}
}
