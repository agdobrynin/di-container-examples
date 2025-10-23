<?php

declare(strict_types=1);

return [
    // simple data
    'app_config.shared_users' => ['user1', 'user2'],
    'app_config.logger_file' => __DIR__ . '/../../../var/app.log',
    'sqlite.dsn' => 'sqlite:' . __DIR__ . '/../../../var/data.db',
];
