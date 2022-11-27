<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\EventDispatcher;

use League\Event\EventDispatcher;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class EventDispatcherFactory
{
    public function __invoke(ContainerInterface $container, string $serviceName): EventDispatcherInterface
    {
        return new EventDispatcher($container->get(ListenerProviderInterface::class));
    }
}
