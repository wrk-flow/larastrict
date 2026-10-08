<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GateRawExpectation
{
    public function __construct(
        public mixed $return,
        public mixed $ability,
        public mixed $arguments = [],
    ) {
    }
}
