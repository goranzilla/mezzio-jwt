<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Provider\Lcobucci;

use GoranZilla\MezzioJwt\Configuration\ConfigurationInterface;
use GoranZilla\MezzioJwt\Exception\JwtBuilderException;
use GoranZilla\MezzioJwt\Provider\JwsProviderInterface;
use Lcobucci\JWT\ClaimsFormatter;
use Lcobucci\JWT\Configuration;
use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

class JwsProviderFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): JwsProviderInterface
    {
        $config = $container->get('config');
        Assert::keyExists(
            $config,
            ConfigurationInterface::CONFIGURATION_IDENTIFIER,
            'JWT settings are not configured properly in *.global.php namespace.',
        );

        $claimsFormat = $config['jwt']['claims_formatter'] ?? null;
        if ($claimsFormat !== null && !$claimsFormat instanceof ClaimsFormatter) {
            throw JwtBuilderException::claimsFormatException();
        }

        /** @var Configuration $jwtConfig */
        $jwtConfig = $container->get(Configuration::class);
        Assert::isInstanceOf($jwtConfig, Configuration::class);

        return new JwsProvider($jwtConfig, $claimsFormat);
    }
}
