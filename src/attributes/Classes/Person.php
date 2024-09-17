<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\DiFactory;

#[DiFactory(DiFactoryPerson::class)]
final class Person
{
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly int $age,
    ){}
}
