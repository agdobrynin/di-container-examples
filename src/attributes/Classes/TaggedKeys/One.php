<?php

declare(strict_types=1);

namespace Attributes\Classes\TaggedKeys;

use Kaspi\DiContainer\Attributes\Tag;

#[Tag(name: 'tags.tagged_key', options: ['key_as' => 'name.one'])]
final class One {}
