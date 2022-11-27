<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Encoder;

use GoranZilla\MezzioJwt\Provider\JwsProviderInterface;
use Psr\Container\ContainerInterface;

class LcobucciJwtEncoderFactory
{
    public function __invoke(ContainerInterface $container): JwtEncoderInterface
    {
        return new LcobucciJwtEncoder($container->get(JwsProviderInterface::class));
    }
}
