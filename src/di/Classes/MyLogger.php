<?php

declare(strict_types=1);

namespace Di\Classes;

use Psr\Log\LoggerInterface;

class MyLogger
{
    public function __construct(protected LoggerInterface $log)
    {
    }

    public function logger(): LoggerInterface
    {
        return $this->log;
    }
}
