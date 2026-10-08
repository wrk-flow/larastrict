<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GateAbilitiesExpectation
{
    /**
     * @param array<array-key, mixed> $return
     */
    public function __construct(
        public array $return,
    ) {
    }
}
