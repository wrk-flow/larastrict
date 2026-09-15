<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final readonly class DispatcherMapExpectation
{
    /**
     * @param array<array-key, mixed> $map
     */
    public function __construct(
        public array $map,
    ) {
    }
}
