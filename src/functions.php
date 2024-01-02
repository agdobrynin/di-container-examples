<?php

declare(strict_types=1);

if (!function_exists('test_title')) {
    function test_title (string $title): string
    {
        return "\n🧪 {$title}\n " . str_repeat('-', 50) . "\n";
    }
}
