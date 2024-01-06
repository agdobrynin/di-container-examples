<?php

declare(strict_types=1);

namespace Attributes\Classes;

use DateTimeZone;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppLogger extends Logger
{
    public function __construct(string $name, string $file, ?DateTimeZone $timezone = null)
    {
        parent::__construct(name: $name, handlers: [new StreamHandler($file)], timezone: $timezone);
    }
}
