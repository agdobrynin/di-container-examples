<?php

declare(strict_types=1);

use Kaspi\DiContainer\DiContainerFactory;

$dependencies = [
    'pdo_dsn' => 'sqlite:'.__DIR__.'/../../var/database.db',
    'users_data' => ['user1', 'user2'],
    'logger_file' => __DIR__.'/../../var/app.log'
];

return DiContainerFactory::make($dependencies);
