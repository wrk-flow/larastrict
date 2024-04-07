<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final class DispatcherDispatchExpectation
{
    public function __construct(
        public readonly array|null $return,
        public readonly mixed $event,
        public readonly mixed $payload = [],
        public readonly mixed $halt = false,
    ) {
    }
}
