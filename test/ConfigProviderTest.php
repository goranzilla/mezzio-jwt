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
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class ConfigProviderTest extends TestCase
{
    public function testProviderConfiguration(): void
    {
        $provider = new ConfigProvider();
        $config   = $provider();

        $this->assertSame([
            'dependencies' => $provider->getDependencies(),
        ], $config);
    }

    public function testProvideExpectedDependencies(): void
    {
        $provider     = new ConfigProvider();
        $dependencies = $provider->getDependencies();

        $this->assertSame([
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
        ], $dependencies);
    }
}
