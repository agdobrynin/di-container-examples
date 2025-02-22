<?php

declare(strict_types=1);

namespace Di\Classes\TaggedKeys;

final class TaggedCollection
{
    public function __construct(
        public readonly iterable $items
    ) {}
}
