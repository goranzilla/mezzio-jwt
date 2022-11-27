<?php

declare(strict_types=1);

namespace GoranZilla\MezzioJwt\ListenerProvider;

use function in_array;

class AttachableListenerProvider implements AttachableListenerProviderInterface
{
    private array $listeners = [];

    public function getListenersForEvent(object $event): iterable
    {
        foreach ($this->listeners as $eventType => $listeners) {
            if (! $event instanceof $eventType) {
                continue;
            }

            foreach ($listeners as $listener) {
                yield $listener;
            }
        }
    }

    public function listen(string $eventType, callable $listener): void
    {
        if (isset($this->listeners[$eventType]) && in_array($listener, $this->listeners[$eventType], true)) {
            // Duplicate detected
            return;
        }

        $this->listeners[$eventType][] = $listener;
    }
}
