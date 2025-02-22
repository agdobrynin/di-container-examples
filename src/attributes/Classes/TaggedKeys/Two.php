<?php

declare(strict_types=1);

namespace Attributes\Classes\TaggedKeys;

use Kaspi\DiContainer\Attributes\Tag;

#[Tag(name: 'tags.tagged_key', options: ['key_as' => 'self::getKey'])]
final class Two
{
    public static function getKey(string $tag): string
    {
        return match ($tag) {
            'tags.tagged_key' => 'name.two',
            'tags.main_services' => 'service.two',
            default => 'tagged.two',
        };
    }
}
