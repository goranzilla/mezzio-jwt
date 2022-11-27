<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Provider;

use GoranZilla\MezzioJwt\Signature\CreatedJWS;

interface JwsProviderInterface
{
    public function create(array $payload, array $header = []): CreatedJWS;
}
