<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Configuration;

use GoranZilla\MezzioJwt\Signer\Lcobucci\SignerInterface;
use InvalidArgumentException;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Ecdsa;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Psr\Container\ContainerInterface;
use RuntimeException;

class LcobucciConfiguration extends AbstractConfiguration
{
    private Signer $signer;

    public function __invoke(ContainerInterface $container, string $requestedName): Configuration
    {
        /** @var SignerInterface $signer */
        $signer = $container->get(SignerInterface::class);
        $this->signer = $signer->getSigner();

        $config = $this->isAsymmetric()
            ? Configuration::forAsymmetricSigner(
                $this->signer,
                $this->getSigningKey(),
                $this->getVerificationKey(),
            )
            : Configuration::forSymmetricSigner($this->signer, $this->getSigningKey());

        $config->setValidationConstraints(
            new SignedWith($this->signer, $this->getSigningKey())
        );

        return $config;
    }

    private function getSigningKey(): Key
    {
        if ($this->isAsymmetric()) {
            if (!$privateKey = $this->getPrivateKey()) {
                throw new InvalidArgumentException('Private key is not set.');
            }

            return $this->getKey($privateKey, $this->getPassphrase() ?? '');
        }

        if (!$secret = $this->getPassPhrase()) {
            throw new InvalidArgumentException('Secret is not set.');
        }

        return $this->getKey($secret);
    }

    protected function getVerificationKey(): Key
    {
        if ($this->isAsymmetric()) {
            if (!$public = $this->getPublicKey()) {
                throw new InvalidArgumentException('Public key is not set.');
            }

            return $this->getKey($public);
        }

        if (!$secret = $this->getPassPhrase()) {
            throw new InvalidArgumentException('Secret is not set.');
        }

        return $this->getKey($secret);
    }

    private function isAsymmetric(): bool
    {
        return is_subclass_of($this->signer, Rsa::class) || is_subclass_of($this->signer, Ecdsa::class);
    }

    private function getKey(string $contents, string $passphrase = ''): Key
    {
        return InMemory::plainText($contents, $passphrase);
    }

    private function readKey(string $type): ?string
    {
        $isPublic = 'public' === $type;
        $key = $isPublic ? $this->getPublicKey() : $this->getPassPhrase();

        if (!$key || !is_file($key) || !is_readable($key)) {
            if ($isPublic) {
                return null;
            }

            throw new RuntimeException();
        }

        return file_get_contents($key);
    }
}
