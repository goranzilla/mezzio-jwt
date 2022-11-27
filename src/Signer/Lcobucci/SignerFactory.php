<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Signer\Lcobucci;

use GoranZilla\MezzioJwt\Enums\Algorithm;
use InvalidArgumentException;
use Lcobucci\JWT\Signer\Ecdsa;
use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

use function is_subclass_of;
use function method_exists;
use function sprintf;

class SignerFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null,
    ): SignerInterface {
        $config = $container->get('config');
        Assert::keyExists($config, 'jwt', 'JWT settings are not configured properly in *.global.php namespace.');

        $jwt = $config['jwt'];

        return new Signer($this->getSignerForAlgorithm($jwt['sign_algo']));
    }

    private function getSignerForAlgorithm(string $signatureAlgorithm): \Lcobucci\JWT\Signer
    {
        $signerMap = Algorithm::cases();

        if (! isset($signerMap[$signatureAlgorithm])) {
            throw new InvalidArgumentException(
                sprintf('The algorithm "%s" is not supported by %s', $signatureAlgorithm, self::class)
            );
        }

        $signerClass = $signerMap[$signatureAlgorithm];

        if (is_subclass_of($signerClass, Ecdsa::class) && method_exists($signerClass, 'create')) {
            return $signerClass::create();
        }

        return new $signerClass();
    }
}
