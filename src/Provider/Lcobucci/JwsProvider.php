<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Provider\Lcobucci;

use DateTimeImmutable;
use Exception;
use GoranZilla\MezzioJwt\Provider\JwsProviderInterface;
use GoranZilla\MezzioJwt\Signature\CreatedJWS;
use Lcobucci\JWT\Builder as BuilderInterface;
use Lcobucci\JWT\ClaimsFormatter;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token\RegisteredClaims;

final class JwsProvider implements JwsProviderInterface
{
    public function __construct(
        private readonly Configuration $configuration,
        private readonly ?ClaimsFormatter $claimsFormatter,
    ) {
    }

    public function create(array $payload, array $header = []): CreatedJWS
    {
        $builder = $this->configuration->builder($this->claimsFormatter);
        $builder = $this->withHeader($builder, $header);
        $builder = $this->withStandardClaims($builder, $payload);

        $e = $token = null;

        try {
            $token = $builder
                ->getToken($this->configuration->signer(), $this->configuration->signingKey())
                ->toString();
        } catch (Exception $e) {
        }

        return new CreatedJWS($token, null === $e);
    }

    private function withHeader(BuilderInterface $builder, array $header): BuilderInterface
    {
        foreach ($header as $name => $value) {
            $builder->withHeader($name, $value);
        }

        return $builder;
    }

    private function withStandardClaims(BuilderInterface $builder, array $payload): BuilderInterface
    {
        foreach ($payload as $key => $value) {
            switch ($key) {
                case RegisteredClaims::ID:
                    $builder->identifiedBy($value);
                    break;
                case RegisteredClaims::EXPIRATION_TIME:
                    $builder->expiresAt(DateTimeImmutable::createFromFormat('U', $value));
                    break;
                case RegisteredClaims::NOT_BEFORE:
                    $builder->canOnlyBeUsedAfter(DateTimeImmutable::createFromFormat('U', $value));
                    break;
                case RegisteredClaims::ISSUED_AT:
                    $builder->issuedAt(DateTimeImmutable::createFromFormat('U', $value));
                    break;
                case RegisteredClaims::ISSUER:
                    $builder->issuedBy($value);
                    break;
                case RegisteredClaims::AUDIENCE:
                    $builder->permittedFor($value);
                    break;
                case RegisteredClaims::SUBJECT:
                    $builder->relatedTo($value);
                    break;
                default:
                    $builder->withClaim($key, $value);
            }
        }

        return $builder;
    }
}
