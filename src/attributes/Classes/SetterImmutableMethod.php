<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\SetupImmutable;
use Monolog\Handler\NullHandler;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class SetterImmutableMethod
{
    public function __construct(private LoggerInterface $logger = new NullLogger()) {}

    #[SetupImmutable('@'.AppLogger::class)]
    public function withLogger(LoggerInterface $logger): static
    {
        $new = clone $this;
        $new->logger = $logger;

        return $new;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
