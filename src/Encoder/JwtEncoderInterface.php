<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Encoder;

interface JwtEncoderInterface
{
    public function encode(array $payload, array $header = []): string;
}
