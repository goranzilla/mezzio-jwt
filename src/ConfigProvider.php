<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt;

use GoranZilla\MezzioJwt\Encoder\JwtEncoderInterface;
use GoranZilla\MezzioJwt\Encoder\LcobucciJwtEncoderFactory;
use GoranZilla\MezzioJwt\EventDispatcher\EventDispatcherFactory;
use GoranZilla\MezzioJwt\ListenerProvider\AttachableListenerProvider;
use GoranZilla\MezzioJwt\Middleware\Encoder\JwtEncoderMiddleware;
use GoranZilla\MezzioJwt\Middleware\Encoder\JwtEncoderMiddlewareFactory;
use GoranZilla\MezzioJwt\Provider\JwsProviderInterface;
use GoranZilla\MezzioJwt\Provider\Lcobucci\ConfigurationBuilderFactory;
use GoranZilla\MezzioJwt\Provider\Lcobucci\JwsProviderFactory;
use GoranZilla\MezzioJwt\Signer\Lcobucci\SignerFactory;
use GoranZilla\MezzioJwt\Signer\Lcobucci\SignerInterface;
use Lcobucci\JWT\Configuration;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * The configuration provider for the Jwt module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'aliases'    => [
                ListenerProviderInterface::class => AttachableListenerProvider::class,
            ],
            'invokables' => [
                AttachableListenerProvider::class => AttachableListenerProvider::class,
            ],
            'factories'  => [
                JwtEncoderInterface::class      => LcobucciJwtEncoderFactory::class,
                JwsProviderInterface::class     => JwsProviderFactory::class,
                JwtEncoderMiddleware::class     => JwtEncoderMiddlewareFactory::class,
                EventDispatcherInterface::class => EventDispatcherFactory::class,
                SignerInterface::class          => SignerFactory::class,
                Configuration::class            => ConfigurationBuilderFactory::class,
            ],
        ];
    }
}
