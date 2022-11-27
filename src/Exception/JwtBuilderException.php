<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Exception;

use InvalidArgumentException;
use Lcobucci\JWT\ClaimsFormatter;

use function sprintf;

class JwtBuilderException extends InvalidArgumentException
{
    public static function claimsFormatException(): self
    {
        return new self(sprintf("JwtBuilder expects claimsFormat to be instance of %s", ClaimsFormatter::class));
    }
}
