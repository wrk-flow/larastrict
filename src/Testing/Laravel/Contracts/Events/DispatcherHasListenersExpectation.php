<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final class DispatcherHasListenersExpectation
{
    public function __construct(
        public readonly bool $return,
        public readonly mixed $eventName,
    ) {
    }
}
