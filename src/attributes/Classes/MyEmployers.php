<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;

class MyEmployers
{
    public function __construct(
        #[Inject('users_data')]
        public array $employers
    ) {}
}
