<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Signature;

class CreatedJWS
{
    private string $token;
    private bool $signed;

    public function __construct(string $token, bool $isSigned)
    {
        $this->token  = $token;
        $this->signed = $isSigned;
    }

    public function isSigned(): bool
    {
        return $this->signed;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
