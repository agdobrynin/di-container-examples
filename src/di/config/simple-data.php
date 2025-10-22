<?php

declare(strict_types=1);

return [
    // simple data
    'app.logger.name' => 'app-logger',
    'app.logger.file' => dirname(__DIR__, 3) . '/var/log.log',
    'app.shared.users' => ['user1', 'user2'],
    'sqlite-dsn' => 'sqlite:' . __DIR__ . '/../../../var/data.db',
];
