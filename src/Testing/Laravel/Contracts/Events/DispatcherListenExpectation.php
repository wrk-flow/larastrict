<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherListenExpectation
{
    public function __construct(
        public mixed $events,
        public mixed $listener = null,
    ) {
    }
}
