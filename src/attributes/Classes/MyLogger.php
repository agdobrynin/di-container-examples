<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;
use Psr\Log\LoggerInterface;

class MyLogger
{
    public function __construct(
        #[Inject]
        public CustomLoggerInterface $customLogger,
        #[Inject(AppLogger::class)]
        public LoggerInterface       $logger,
    ) {}
}
