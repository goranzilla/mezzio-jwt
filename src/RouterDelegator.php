<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt;

use GoranZilla\MezzioJwt\Middleware\Encoder\JwtEncoderMiddleware;
use Mezzio\Application;
use Mezzio\Authentication\AuthenticationMiddleware;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Psr\Container\ContainerInterface;

class RouterDelegator
{
    public function __invoke(
        ContainerInterface $container,
        string $serviceName,
        callable $callback
    ): Application {
        /** @var Application $app */
        $app = $callback();

        $app->post('/api/login', [
            BodyParamsMiddleware::class,
            AuthenticationMiddleware::class,
            JwtEncoderMiddleware::class,
        ], 'api.login');

        return $app;
    }
}
