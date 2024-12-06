<?php
declare(strict_types=1);

return static function (string ...$file): \Generator {
    foreach ($file as $srcFile) {
        $src = require $srcFile;

        if ($src instanceof \Closure) {
            yield from $src();
        } elseif (\is_array($src)) {
            yield from $src;
        } else {
            throw new \InvalidArgumentException('Unexpected value from file: ' . $srcFile);
        }
    }
};
