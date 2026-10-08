<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Events;

final readonly class DispatcherUntilExpectation
{
    /**
     * @param array<mixed>|null    $return
     */
    public function __construct(
        public array|null $return,
        public string|object $event,
        public mixed $payload = [],
    ) {
    }
}
