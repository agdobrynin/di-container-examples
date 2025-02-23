<?php

declare(strict_types=1);

namespace Attributes\Classes\TaggedKeys;

use Kaspi\DiContainer\Attributes\Tag;
use Kaspi\DiContainer\Attributes\TaggedAs;

#[Tag(name: 'tags.tagged_key')]
final class TaggedCollection
{
    public function __construct(
        #[TaggedAs(name: 'tags.tagged_key', key: 'key_as')] // own class will be excluded from collection.
        public readonly iterable $items
    ) {}
}
