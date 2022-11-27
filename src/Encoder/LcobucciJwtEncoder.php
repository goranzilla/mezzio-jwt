<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Encoder;

use GoranZilla\MezzioJwt\Provider\JwsProviderInterface;
use LogicException;

class LcobucciJwtEncoder implements JwtEncoderInterface
{
    private JwsProviderInterface $jwsProvider;

    public function __construct(JwsProviderInterface $jwsProvider)
    {
        $this->jwsProvider = $jwsProvider;
    }

    public function encode(array $payload, array $header = []): string
    {
        $jws = $this->jwsProvider->create($payload, $header);

        if (! $jws->isSigned()) {
            throw new LogicException();
        }

        return $jws->getToken();
    }
}
