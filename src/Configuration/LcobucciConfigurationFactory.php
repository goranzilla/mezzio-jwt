<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Configuration;

use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

class LcobucciConfigurationFactory
{
    public function __invoke(ContainerInterface $container): LcobucciConfiguration
    {
        $parameters = $container->get('config')[LcobucciConfiguration::CONFIGURATION_IDENTIFIER] ?? [];
        Assert::isMap($parameters);

        return new LcobucciConfiguration($parameters);
    }
}
