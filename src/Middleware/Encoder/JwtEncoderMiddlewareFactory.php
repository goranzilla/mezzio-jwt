<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Middleware\Encoder;

use GoranZilla\MezzioJwt\Encoder\JwtEncoderInterface;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class JwtEncoderMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): JwtEncoderMiddleware
    {
        return new JwtEncoderMiddleware(
            $container->get(JwtEncoderInterface::class),
            $container->get(EventDispatcherInterface::class)
        );
    }
}
