<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;

class MyClass
{
    public function __construct(
        #[Inject(arguments: ['dsn' => '@app.sqlite-dsn'])]
        public \PDO $pdo
    ) {}
}
