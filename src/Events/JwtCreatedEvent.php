<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Events;

use Mezzio\Authentication\UserInterface;
use Psr\Http\Message\ServerRequestInterface;

class JwtCreatedEvent
{
    private UserInterface $user;
    private array $payload;
    private array $header;
    private ?ServerRequestInterface $request;

    public function __construct(
        UserInterface $user,
        array $payload,
        array $header = [],
        ?ServerRequestInterface $request = null
    ) {
        $this->user    = $user;
        $this->payload = $payload;
        $this->header  = $header;
        $this->request = $request;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function setHeader(array $header): void
    {
        $this->header = $header;
    }

    public function getRequest(): ?ServerRequestInterface
    {
        return $this->request;
    }
}
