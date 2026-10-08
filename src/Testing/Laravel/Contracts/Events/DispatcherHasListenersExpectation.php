<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherHasListenersExpectation
{
    public function __construct(
        public bool $return,
        public mixed $eventName,
    ) {
    }
}
