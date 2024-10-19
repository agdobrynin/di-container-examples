<?php

declare(strict_types=1);

namespace Attributes\Classes\Circular;

use Kaspi\DiContainer\Attributes\Service;

#[Service(CircularFirstClass::class)]
interface CircularInjectInterface {}
