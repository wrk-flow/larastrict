<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final readonly class GateAnyExpectation
{
    public function __construct(
        public bool $return,
        public mixed $abilities,
        public mixed $arguments = [],
    ) {
    }
}
