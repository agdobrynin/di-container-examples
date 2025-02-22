<?php

declare(strict_types=1);

namespace Di\Classes\TaggedKeys;

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
