<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;

class MyClass
{
    public function __construct(
        #[Inject('app.pdo')]
        public \PDO $pdo
    ) {}
}
