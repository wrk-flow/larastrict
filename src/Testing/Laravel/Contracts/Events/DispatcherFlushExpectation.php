<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final class DispatcherFlushExpectation
{
    public function __construct(
        public readonly mixed $event,
    ) {
    }
}
