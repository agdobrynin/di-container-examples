<?php

declare(strict_types=1);

namespace Attributes\Classes\TaggedKeys;

use Kaspi\DiContainer\Attributes\TaggedAs;

final class TaggedCollection
{
    public function __construct(
        #[TaggedAs(name: 'tags.tagged_key', key: 'key_as')]
        public readonly iterable $items
    ) {}
}
