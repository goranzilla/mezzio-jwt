<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Enums;

use Lcobucci\JWT\Signer\Ecdsa\Sha256 as ES256;
use Lcobucci\JWT\Signer\Ecdsa\Sha384 as ES384;
use Lcobucci\JWT\Signer\Ecdsa\Sha512 as ES512;
use Lcobucci\JWT\Signer\Hmac\Sha256 as HS256;
use Lcobucci\JWT\Signer\Hmac\Sha384 as HS384;
use Lcobucci\JWT\Signer\Hmac\Sha512 as HS512;
use Lcobucci\JWT\Signer\Rsa\Sha256 as RS256;
use Lcobucci\JWT\Signer\Rsa\Sha384 as RS384;
use Lcobucci\JWT\Signer\Rsa\Sha512 as RS512;

enum Algorithm: string
{
    case HS256 = 'HS256';
    case HS384 = 'HS384';
    case HS512 = 'HS512';
    case RS256 = 'RS256';
    case RS384 = 'RS384';
    case RS512 = 'RS512';
    case ES256 = 'ES256';
    case ES384 = 'ES384';
    case ES512 = 'ES512';

    public function signer(): string
    {
        return match ($this) {
            self::HS256 => HS256::class,
            self::HS384 => HS384::class,
            self::HS512 => HS512::class,
            self::RS256 => RS256::class,
            self::RS384 => RS384::class,
            self::RS512 => RS512::class,
            self::ES256 => ES256::class,
            self::ES384 => ES384::class,
            self::ES512 => ES512::class,
        };
    }
}
