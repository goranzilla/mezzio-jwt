<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Exception;

use InvalidArgumentException;

class InvalidConfigurationException extends InvalidArgumentException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function create(string $message): self
    {
        return new self($message);
    }
}
