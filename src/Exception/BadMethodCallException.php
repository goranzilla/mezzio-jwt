<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Exception;

use BadMethodCallException as BaseBadMethodCallException;

class BadMethodCallException extends BaseBadMethodCallException
{
    public static function fromMissingSetterMethod(string $property, string $expectedSetterMethod): self
    {
        return new self(
            sprintf(
                'Missing setter method for property %s; expected setter %s',
                $property,
                $expectedSetterMethod,
            )
        );
    }
}
