<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Events;

class JwtEncodedEvent
{
    private string $jws;

    public function __construct(string $jws)
    {
        $this->jws = $jws;
    }

    public function getJws(): string
    {
        return $this->jws;
    }
}
