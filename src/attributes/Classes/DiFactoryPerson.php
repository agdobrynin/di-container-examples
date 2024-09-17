<?php

declare(strict_types=1);

namespace Attributes\Classes;

use Kaspi\DiContainer\Interfaces\DiFactoryInterface;
use Psr\Container\ContainerInterface;

class DiFactoryPerson implements DiFactoryInterface
{

    public function __invoke(ContainerInterface $container): Person
    {
        return new Person(name: 'Piter', surname: 'Good', age: 30);
    }
}
