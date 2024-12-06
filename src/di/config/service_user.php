<?php

declare(strict_types=1);

use Di\Classes\MyUsers;
use function Kaspi\DiContainer\{diAutowire, diGet};

return static function (): \Generator {
    yield diAutowire(MyUsers::class)
        ->bindArguments(users: diGet('app.shared.users'));
};
