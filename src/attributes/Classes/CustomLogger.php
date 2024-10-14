<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;

class CustomLogger implements CustomLoggerInterface
{
    public function __construct(
        #[Inject('@logger_file')]
        protected string $file,
    )
    {
    }

    public function loggerFile(): string
    {
        return $this->file;
    }
}
