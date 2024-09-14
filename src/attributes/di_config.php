<?php

declare(strict_types=1);

return [
    'pdo_dsn' => '@app.sqlite_dsn',
    'app' => [
        'sqlite_dsn' => 'sqlite:'.__DIR__.'/../../var/database.db',
        'shared' => [
            'users' => '@test_users',
        ],
        'logger' => [
            'name' => 'app-logger',
            'file' => __DIR__.'/../../var/app_logger.log',
        ],
    ],
    'logger_file' => __DIR__.'/../../var/app.log',
    'test_users' => ['user1', 'user2'],
];
