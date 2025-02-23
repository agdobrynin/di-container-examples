<?php

declare(strict_types=1);

use Attributes\Classes\TaggedKeys\One;
use Attributes\Classes\TaggedKeys\TaggedCollection;
use Attributes\Classes\TaggedKeys\Three;
use Attributes\Classes\TaggedKeys\Two;
use function Kaspi\DiContainer\diAutowire;

return static function (): \Generator {
    yield diAutowire(One::class);

    yield diAutowire(Two::class);

    yield diAutowire(Three::class);

    yield diAutowire(TaggedCollection::class);
};
