<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Enums;

enum Algorithm
{
    case HS256;
    case HS384;
    case HS512;
    case RS256;
    case RS384;
    case RS512;
    case ES256;
    case ES384;
    case ES512;

    public function signer(): string
    {
        return match ($this) {
            self::HS256 => 'HS256',
            self::HS384 => 'HS384',
            self::HS512 => 'HS512',
            self::RS256 => 'RS256',
            self::RS384 => 'RS384',
            self::RS512 => 'RS512',
            self::ES256 => 'ES256',
            self::ES384 => 'ES384',
            self::ES512 => 'ES512',
        };
    }
}
