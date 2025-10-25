<?php

declare(strict_types=1);

namespace Attributes\Classes\AutowireMulti;

use Attributes\Classes\MyEmployers;
use Kaspi\DiContainer\Attributes\Autowire;

#[Autowire(isSingleton: true)]
#[Autowire(id: 'services.autowire_multi')]
final class AutowireMulti
{
    public function __construct(public readonly MyEmployers $employers) {}
}
