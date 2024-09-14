<?php

declare(strict_types=1);

if (!function_exists('test_title')) {
    function test_title(string $title = '', string $icon = '🧪', int $times = 51): string
    {
        return "\n{$icon}" . ($title ? ' ' . $title : '') . "\n " . str_repeat('-', $times) . "\n";
    }
}

if (!function_exists('test_group')) {
    function test_group(string $description, \Closure $closure): void
    {
        print test_title($description, '🚩', 60);
        ob_start(static fn(string $buffer) => preg_replace(['/\n/'], "\n\t", $buffer));
        $closure();
        ob_end_flush();
        print test_title(icon: '🏁', times: 60);
    }
}

if (!function_exists('mem')) {
    function mem(): string
    {
        $base = log(\memory_get_peak_usage(true)) / \log(1024);
        $suffix = [' b', ' kb', ' Mb', ' Gb'][\floor($base)];

        return '📊 ' . round(1024 ** ($base - \floor($base)), 4) . $suffix;

    }
}
