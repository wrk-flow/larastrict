<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final class DispatcherListenExpectation
{
    public function __construct(
        public readonly mixed $events,
        public readonly mixed $listener = null,
    ) {
    }
}
