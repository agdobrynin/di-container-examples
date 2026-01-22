<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Attributes\DiFactory;
use Kaspi\DiContainer\Attributes\Inject;

class DiFactoryOnProperty
{
    public function __construct(
        #[DiFactory(DiFactoryPerson::class)]
        public Person $person
    ) {
    }
}
