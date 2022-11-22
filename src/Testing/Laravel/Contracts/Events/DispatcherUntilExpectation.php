<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final class DispatcherUntilExpectation
{
    public function __construct(
        public readonly mixed $return,
        public readonly mixed $event,
        public readonly mixed $payload = [],
    ) {
    }
}
