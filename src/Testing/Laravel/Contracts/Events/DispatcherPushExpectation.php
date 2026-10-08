<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherPushExpectation
{
    public function __construct(
        public mixed $event,
        public mixed $payload = [],
    ) {
    }
}
