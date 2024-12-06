<?php

declare(strict_types=1);

return [
    // simple data
    'app.logger.name' => 'app-logger',
    'app.logger.file' => __DIR__ . '/../../../var/log.log',
    'app.shared.users' => ['user1', 'user2'],
    'sqlite-dsn' => 'sqlite:' . __DIR__ . '/../../../var/data.db',
];
