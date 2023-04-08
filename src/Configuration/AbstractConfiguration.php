<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Configuration;

use GoranZilla\MezzioJwt\Exception\BadMethodCallException;
use GoranZilla\MezzioJwt\Exception\InvalidConfigurationException;

abstract class AbstractConfiguration implements ConfigurationInterface
{
    protected string $publicKey;
    protected string $privateKey;
    protected string $passPhrase;

    public function __construct(array $parameters)
    {
        try {
            $this->exchangeArray($parameters);
        } catch (BadMethodCallException $exception) {
            throw InvalidConfigurationException::create($exception->getMessage());
        }
    }

    private function exchangeArray(array $parameters)
    {
        foreach ($parameters as $property => $value) {
            $property = lcfirst(str_replace('_', '', ucwords($property, '_')));
            $setter = sprintf('set%s', ucfirst($property));
            $callable = [$this, $setter];
            if (!is_callable($callable)) {
                throw BadMethodCallException::fromMissingSetterMethod($property, $setter);
            }

            call_user_func($callable, $value);
        }
    }

    protected function getPublicKey(): string
    {
        return $this->publicKey;
    }

    protected function setPublicKey(string $publicKey): void
    {
        $this->publicKey = $publicKey;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function setPrivateKey(string $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    protected function getPassPhrase(): string
    {
        return $this->passPhrase;
    }

    protected function setPassPhrase(string $passPhrase): void
    {
        $this->passPhrase = $passPhrase;
    }
}
