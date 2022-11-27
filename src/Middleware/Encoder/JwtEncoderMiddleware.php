<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\Middleware\Encoder;

use GoranZilla\MezzioJwt\Encoder\JwtEncoderInterface;
use GoranZilla\MezzioJwt\Events\JwtCreatedEvent;
use GoranZilla\MezzioJwt\Events\JwtEncodedEvent;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Authentication\UserInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtEncoderMiddleware implements MiddlewareInterface
{
    private const USER  = 'user';
    private const ROLES = 'roles';

    private JwtEncoderInterface $jwtEncoder;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(JwtEncoderInterface $jwtEncoder, EventDispatcherInterface $eventDispatcher)
    {
        $this->jwtEncoder      = $jwtEncoder;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var UserInterface $user */
        $user = $request->getAttribute(UserInterface::class);

        $payload = [
            self::USER  => $user->getIdentity(),
            self::ROLES => $user->getRoles(),
        ];

        $jwt = $this->generateJwt($user, $payload, $request);

        return new JsonResponse(['access_token' => $jwt]);
    }

    private function generateJwt(UserInterface $user, array $payload, ServerRequestInterface $request): string
    {
        $jwtCreatedEvent = new JwtCreatedEvent($user, $payload, [], $request);
        $this->eventDispatcher->dispatch($jwtCreatedEvent);

        $jws = $this->jwtEncoder->encode($jwtCreatedEvent->getPayload(), $jwtCreatedEvent->getHeader());

        $jwtEncodedEvent = new JwtEncodedEvent($jws);
        $this->eventDispatcher->dispatch($jwtEncodedEvent);

        return $jws;
    }
}
