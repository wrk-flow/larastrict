<?php

declare(strict_types=1);

namespace LaraStrict\Database\Listeners;

use Closure;
use Illuminate\Contracts\Events\Dispatcher;
use LaraStrict\Database\Events\AbstractModelChangedEvent;

/**
 * @template T of AbstractModelChangedEvent
 */
abstract class AbstractDispatchChangesEventsListener
{
    public function __construct(
        private readonly Dispatcher $eventDispatcher
    ) {
    }

    /**
     * @param T $event
     */
    public function handle(AbstractModelChangedEvent $event): void
    {
        foreach ($this->attributesToEvent() as $attribute => $createEvent) {
            if (array_key_exists($attribute, $event->changes) === false) {
                continue;
            }

            $dispatchEvent = $createEvent($event->changesOriginalValues[$attribute], $event);

            if (is_object($dispatchEvent) || is_string($dispatchEvent)) {
                $this->eventDispatcher->dispatch($dispatchEvent);
            }
        }
    }

    /**
     * @return array<string, Closure(mixed,T):mixed>
     */
    abstract public function attributesToEvent(): array;
}
