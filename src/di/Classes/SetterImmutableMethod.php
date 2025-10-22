<?php

declare(strict_types=1);

namespace Di\Classes;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class SetterImmutableMethod
{
    public function __construct(private LoggerInterface $logger = new NullLogger()) {}

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
