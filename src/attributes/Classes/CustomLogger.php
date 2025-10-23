<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\Inject;

class CustomLogger implements CustomLoggerInterface
{
    public function __construct(
        #[Inject('app_config.logger_file')]
        protected string $file,
    )
    {
        if (false === fopen($this->file, 'ab')) {
            throw new \InvalidArgumentException("Cannot open '{$this->file}'");
        }
    }

    public function loggerFile(): string
    {
        return realpath($this->file);
    }
}
