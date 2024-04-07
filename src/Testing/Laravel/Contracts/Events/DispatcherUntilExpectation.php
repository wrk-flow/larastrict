<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final class DispatcherUntilExpectation
{
    /**
     * @param array<mixed>|null    $return
     */
    public function __construct(
        public readonly array|null $return,
        public readonly string|object $event,
        public readonly mixed $payload = [],
    ) {
    }
}
