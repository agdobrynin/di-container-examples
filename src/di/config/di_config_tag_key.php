<?php

declare(strict_types=1);

use Di\Classes\TaggedKeys\One;
use Di\Classes\TaggedKeys\TaggedCollection;
use Di\Classes\TaggedKeys\Three;
use Di\Classes\TaggedKeys\Two;
use function Kaspi\DiContainer\diAutowire;
use function Kaspi\DiContainer\diTaggedAs;

return static function (): \Generator {
    yield diAutowire(One::class)
        ->bindTag(name: 'tags.tagged_key', options: ['key_as' => 'name.one']);

    yield diAutowire(Two::class)
        ->bindTag(name: 'tags.tagged_key', options: ['key_as' => 'self::getKey']);

    yield diAutowire(Three::class)
        ->bindTag(name: 'tags.service_other', options: ['key_as' => 'name.three']);

    yield diAutowire(TaggedCollection::class)
        ->bindArguments(items: diTaggedAs(tag: 'tags.tagged_key', key: 'key_as'))
        ->bindTag(name: 'tags.tagged_key'); // own class will be excluded from collection.
};
