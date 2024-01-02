<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;

class MyLogger
{
    public function __construct(
        #[Inject]
        public CustomLoggerInterface $customLogger
    ) {}
}
