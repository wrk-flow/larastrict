<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherDispatchExpectation
{
    /**
     * @param array<array-key, mixed> $return
     */
    public function __construct(
        public array|null $return,
        public mixed $event,
        public mixed $payload = [],
        public mixed $halt = false,
    ) {
    }
}
