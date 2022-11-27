<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Signer\Lcobucci;

use Lcobucci\JWT\Signer as JwtSigner;

interface SignerInterface
{
    public function getSigner(): JwtSigner;
}
