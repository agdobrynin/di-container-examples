<?php

declare(strict_types=1);

namespace Di\Classes;

class Travel
{
    public function __construct(
        public string $travelFrom,
        public string $travelTo,
        public object $travelOptions,
    )
    {
    }
}
