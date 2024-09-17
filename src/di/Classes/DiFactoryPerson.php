<?php

declare(strict_types=1);

namespace Di\Classes;

use Kaspi\DiContainer\Interfaces\DiFactoryInterface;
use Psr\Container\ContainerInterface;

class DiFactoryPerson implements DiFactoryInterface
{

    public function __invoke(ContainerInterface $container): Person
    {
        return new Person(name: 'Piter', age: 22);
    }
}
