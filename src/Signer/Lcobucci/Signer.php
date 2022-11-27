<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Signer\Lcobucci;

use Lcobucci\JWT\Signer as JwtSigner;

class Signer implements SignerInterface
{
    private JwtSigner $signer;

    public function __construct(JwtSigner $signer)
    {
        $this->signer = $signer;
    }

    public function getSigner(): JwtSigner
    {
        return $this->signer;
    }
}
