<?php

declare(strict_types=1);

use Di\Classes\MyEmployers;
use function Kaspi\DiContainer\{diAutowire, diGet};

return [
    diAutowire(MyEmployers::class)
        ->bindArguments(employers: diGet('app.shared.users'))
];
