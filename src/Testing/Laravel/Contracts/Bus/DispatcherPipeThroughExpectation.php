<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Bus;

final readonly class DispatcherPipeThroughExpectation
{
    /**
     * @param array<array-key, mixed> $pipes
     */
    public function __construct(
        public array $pipes,
    ) {
    }
}
