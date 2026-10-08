<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherFlushExpectation
{
    public function __construct(
        public mixed $event,
    ) {
    }
}
