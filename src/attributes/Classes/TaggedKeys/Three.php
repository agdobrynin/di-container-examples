<?php

declare(strict_types=1);

namespace Attributes\Classes\TaggedKeys;

use Kaspi\DiContainer\Attributes\Tag;

#[Tag(name: 'tags.service_other', options: ['key_as' => 'name.three'])]
final class Three {}
