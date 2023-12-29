<?php

declare(strict_types=1);

namespace DiContainerExample\App\Classes;

class ClassFirst implements ClassInterface
{
    public function __construct(protected string $file) {}

    public function file(): string
    {
        return realpath($this->file);
    }
}
